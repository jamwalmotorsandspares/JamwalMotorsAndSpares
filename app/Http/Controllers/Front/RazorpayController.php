<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        // Amount must be in paise
        $amount = (int) round($order->total_price * 100);

        $razorpayOrder = $api->order->create([
            'receipt' => 'ORDER_' . $order->id,
            'amount' => $amount,
            'currency' => 'INR',
        ]);

        $order->update([
            'razorpay_order_id' => $razorpayOrder['id'],
            'payment_status' => 2,//'pending',
        ]);

        return response()->json([
            'success' => true,
            'key' => config('services.razorpay.key'),
            'razorpay_order_id' => $razorpayOrder['id'],
            'amount' => $amount,
            'currency' => 'INR',
            'order_id' => $order->id,
        ]);
    }

    public function verify(Request $request)
    {

    $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        try {

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $order = Order::where(
                'razorpay_order_id',
                $request->razorpay_order_id
            )->first();

            if (!$order) {

                    return response()->json([
                        'success' => false,
                        'message' => 'Local order not found.'
                    ], 404);
                }
            $order->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_status' => 1,
                'payment_method' => 'razorpay',
            ]);
            session()->flash('order_success', __('site.order_successfully'));
            return response()->json([
                'success' => true,
                'message' => 'Payment successful.',
                'redirect' => route(
                    'orders.show',
                    $order->id
                ),
            ]);


         } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {

        \Log::error(
            'Razorpay signature error: ' . $e->getMessage()
        );

        return response()->json([
            'success' => false,
            'message' => 'Invalid Razorpay signature.'
        ], 422);

        } catch (Exception $e) {
            \Log::error(
            'Razorpay verification error: ' . $e->getMessage()
        );
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function webhook(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header(
            'X-Razorpay-Signature'
        );

        $secret = config(
            'services.razorpay.webhook_secret'
        );

        $expectedSignature = hash_hmac(
            'sha256',
            $payload,
            $secret
        );

        if (!hash_equals(
            $expectedSignature,
            $signature
        )) {
            return response()->json([
                'message' => 'Invalid signature'
            ], 400);
        }

        $data = json_decode($payload, true);

        $event = $data['event'] ?? null;

        if ($event === 'order.paid') {

            $razorpayOrderId =
                $data['payload']['order']['entity']['id']
                ?? null;

            $razorpayPaymentId =
                $data['payload']['payment']['entity']['id']
                ?? null;

            if ($razorpayOrderId) {

                $order = Order::where(
                    'razorpay_order_id',
                    $razorpayOrderId
                )->first();

                if ($order) {

                    $order->update([
                        'razorpay_payment_id' =>
                            $razorpayPaymentId,

                        'payment_status' => 'paid',

                        'payment_method' => 'razorpay',
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true
        ]);
    }
}