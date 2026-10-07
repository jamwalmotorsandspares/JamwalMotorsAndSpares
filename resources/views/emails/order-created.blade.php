<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Order Confirmed</title>
</head>

<body style="margin:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;color:#222;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:25px 10px;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0"
       style="max-width:600px;width:100%;background:#fff;border-radius:10px;overflow:hidden;">

    <!-- Header -->
    <tr>
        <td style="background:#111827;padding:22px;text-align:center;">
            <h1 style="margin:0;color:#fff;font-size:23px;">
                Jamwal Motors & Spares
            </h1>
        </td>
    </tr>

    <!-- Success -->
    <tr>
        <td style="padding:30px;text-align:center;">

            <div style="font-size:42px;">✓</div>

            <h2 style="margin:10px 0 5px;">
                Order Confirmed!
            </h2>

            <p style="margin:0;color:#666;font-size:14px;">
                Thank you for your order, {{ \Auth::user()->first_name.' '.\Auth::user()->last_name }}.
            </p>

        </td>
    </tr>

    <!-- Order summary -->
    <tr>
        <td style="padding:0 30px 25px;">

            <table width="100%" cellpadding="8" cellspacing="0"
                   style="background:#f8f8f8;border-radius:8px;">

                <tr>
                    <td style="color:#777;font-size:13px;">
                        Order Number
                    </td>
                    <td align="right" style="font-weight:bold;">
                        #{{ $order->id }}
                    </td>
                </tr>

                <tr>
                    <td style="color:#777;font-size:13px;">
                        Order Date
                    </td>
                    <td align="right">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </td>
                </tr>

                <tr>
                    <td style="color:#777;font-size:13px;">
                        Payment
                    </td>
                    <td align="right">
                        {{ $order->payment_method }}
                    </td>
                </tr>

            </table>

        </td>
    </tr>

    <!-- Products -->
    <tr>
        <td style="padding:0 30px 20px;">

            <h3 style="margin:0 0 15px;">
                Order Details
            </h3>

            @foreach($order->products as $product)

            <table width="100%" cellpadding="8" cellspacing="0"
                   style="border-bottom:1px solid #eee;">

                <tr>
                    <td>
                        <strong>{{ $product->name }}</strong><br>

                        <span style="font-size:12px;color:#777;">
                            Qty: {{ $product->pivot->quantity }}
                        </span>
                    </td>

                    <td align="right">
                        ₹{{ number_format($product->pivot->price, 2) }}
                    </td>
                </tr>

            </table>

            @endforeach

        </td>
    </tr>

    <!-- Total -->
    <tr>
        <td style="padding:15px 30px 25px;">

            <table width="100%">
                <tr>
                    <td style="font-size:18px;font-weight:bold;">
                        Total
                    </td>

                    <td align="right"
                        style="font-size:20px;font-weight:bold;">
                        ₹{{ number_format($order->total_price, 2) }}
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <!-- CTA -->
    <tr>
        <td style="text-align:center;padding:0 30px 35px;">

            <a href="{{ url('/en/orders/' . $order->id) }}"
               style="display:inline-block;background:#e63946;
                      color:#fff;padding:13px 30px;
                      border-radius:6px;text-decoration:none;
                      font-weight:bold;"  target="_blank">
                View Order
            </a>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8f8f8;text-align:center;padding:20px;">

            <p style="margin:0;font-size:12px;color:#888;">
                Thank you for shopping with Jamwal Motors and Spares.
            </p>

            <p style="margin:8px 0 0;font-size:12px;color:#999;">
                © {{ date('Y') }} Jamwal Motors and Spares
            </p>

        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
