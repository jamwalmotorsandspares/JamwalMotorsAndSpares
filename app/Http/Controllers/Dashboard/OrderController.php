<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Admin;
use App\Traits\ReportTrait;
use App\Traits\InvoiceTrait;
use App\Exports\ExportOrder;
// Exel Order
use Illuminate\Http\Request;
use App\Exports\ExportOrderInvoice;
use App\Notifications\NewOrderNotification;
use App\Http\Controllers\Controller;
// ./
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use InvoiceTrait,ReportTrait;

    public function index(Request $request)
    {
        $this->authorize('check-permissions', 'read_orders');
        if($request->exists('daterange')){
            // $request->validate([
            //     'daterange' => 'date_format:m/d/Y - m/d/Y',
            // ]);
        $request->daterange = explode(" - ",$request->daterange);
           $request->daterange[0] = date('Y-m-d',strtotime($request->daterange[0]));
           $request->daterange[1] = date('Y-m-d',strtotime($request->daterange[1]));
        }
        $orders = Order::with('user')->when($request->search,function ($query) use ($request){
            return $query->where('invoice_no','Like','%'.$request->search.'%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')->orWhere('last_name','like','%'.$request->search.'%');
            });
        })->when($request->status,function ($query) use ($request){
            return $query->where('payment_status',$request->status);
        })->when($request->payment,function ($query) use ($request){
            return $query->where('payment_method',$request->payment);
        })->when($request->daterange,function ($query) use ($request){
            return $query->whereBetween('created_at',[$request->daterange[0],$request->daterange[1]]);
        })->when($request->date,function ($query) use ($request){
            return $query->whereDate('created_at',$request->date);
        })->latest()->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }

     public function create()
    {
        $this->authorize('check-permissions', 'create_orders');
        $clients = User::all();
        return view('dashboard.orders.create',compact('clients'));
    }

    public function store(Request $request)
    {

      $validator = Validator::make($request->all(), [
            'client' => 'required',
            'products' => 'required|array|min:1',
            'products.*' => 'required',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'payment_type' => 'required',
            'payment_method' => 'required',
        ]);

$validator->after(function ($validator) use ($request) {

        $productIds = collect($request->products)->keys()->toArray();
        $products = Product::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        foreach ($request->products as $productId => $item) {
            $product = $products->get($productId);

            $quantity = (int) $item['quantity'];
            if ($quantity > $product->stock) {
                  $validator->errors()->add("products.$productId.quantity","Only {$product->stock} units of {$product->name_en} are available.");
            }
        }
        });
        $validator->validate();
        $nextInvoiceNumber = $this->OrderInvoiceIncrement();
        $order = Order::create([
            'user_id' => $request->client,
            'invoice_no' => $nextInvoiceNumber,
        ]);
        $order->products()->attach($request->products);
        $total_price = 0;
        // start foreach
        foreach ($request->products as $purchase_product) {
            $total_price +=  $purchase_product['price'] * $purchase_product['quantity'];
        }//end foreach

        // start update order data table
        $order->update([
            'total_price' => $total_price,
            'payment_method' => $request->payment_method,
        ]);// end update order data table

        //admin notification
        $admins = Admin::where('role', 'super_admin')->first();

        // foreach ($admins as $admin) {
            $admins->notify(new NewOrderNotification($order));
        // }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.show',$order->id);
    }


    public function show(Order $order)
    {
        $this->authorize('check-permissions', 'read_orders');

        return view('dashboard.orders.show',compact('order'));
    }


    public function edit(Order $order)
    {
        $this->authorize('check-permissions', 'update_orders');

        return view('dashboard.orders.edit',compact('order'));
    }


    public function update(Request $request, Order $order)
    {
        $this->authorize('check-permissions', 'update_orders');

        $request->validate([
            'payment_status' => 'required|in:1,2,3',
            'tracking' => 'required|in:1,2,3,4,5',
            'address' => 'required|string|max:50',
            'building' => 'required|integer|max:1000',
            'apartment' => 'required|integer|max:100',
            'floor' => 'required|integer|max:50',
        ]);
        $order->update([
            'payment_status'=> $request->payment_status,
            'tracking'=> $request->tracking,
            'address'=> $request->address,
            'building'=> $request->building,
            'apartment'=> $request->apartment,
            'floor'=> $request->floor,
        ]);
        if($request->products){
            foreach ($order->products as $product) {
                if(in_array($product->id,$request->products)){
                    $order->products()->updateExistingPivot($product->id,[
                        'return_status' => true,
                    ]);
                    $products_qyt = $product->pivot->quantity;
                    $products_price = $product->pivot->price * $products_qyt;
                    $this->ReportSaleIncrement($products_price,$products_qyt);
                    $product->update([
                        'stock' => $product->stock +  $product->pivot->quantity,
                    ]);
                }
            }
        }
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    public function destroy($test,Request $request)
    {
        $orders_arr = explode(",",$request->mass_delete);
        $order = Order::whereIn('id', $orders_arr);
        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    public function exportOrders(Request $request){
        $this->authorize('check-permissions', 'create_admins');
        return Excel::download(new ExportOrder, 'orders.xlsx');
    }

    public function exportInvoiceOrder($id)
    {
        return Excel::download(new ExportOrderInvoice($id), 'invoices.xlsx');
    }

     public function active(Order $order)
    {
        // start stock area
        foreach ($order->products as $index => $product) {
            $products_qyt = $product->pivot->quantity;
            $products_price = $product->pivot->price * $products_qyt;
            if($order->payment_status == 2){ // if order payment status pending
                // update daily report
                $this->ReportSaleIncrement($products_price,$products_qyt);
                $product->update([
                    'stock' => $product->stock - $product->pivot->quantity,
                        ]);

            }else{ // if order payment type return
                // update daily report
                $this->ReportSaleIncrement($products_price,$products_qyt);
                  // pricing policy
                $balance_value = $product->stock * $product->purchase_price;
                $new_balance_value = $product->pivot->quantity * $product->pivot->price;
                $total_balance_value = $balance_value + $new_balance_value;
                $total_quantity = $product->pivot->quantity + $product->stock;
                // pricing policy end
                $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
                'purchase_price' => $total_balance_value / $total_quantity,
                    ]);
            }
        }// end stock area

            // order area
            $order->update([
                'payment_status'=> 1,
                'tracking'=> 5,
                'address'=> $order->user->street.",".$order->user->city,
                'building'=> $order->user->building,
                'apartment'=> $order->user->apartment,
                'floor'=> $order->user->floor,
                'user_id'=>$order->user_id,
            ]);
            // end order area
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.show',$order->id);
    }

}
