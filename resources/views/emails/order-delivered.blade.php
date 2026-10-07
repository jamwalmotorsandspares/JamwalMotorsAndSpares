<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Order Delivered</title>
</head>

<body style="margin:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">

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

    <!-- Delivered -->
    <tr>
        <td style="padding:35px 30px;text-align:center;">

            <div style="font-size:48px;">📦</div>

            <h2 style="margin:12px 0 8px;">
                Order Delivered!
            </h2>

            <p style="margin:0;color:#666;">
                Your order has been successfully delivered.
            </p>

        </td>
    </tr>

    <!-- Order -->
    <tr>
        <td style="padding:0 30px 25px;">

            <table width="100%" cellpadding="10"
                   style="background:#f8f8f8;border-radius:8px;">

                <tr>
                    <td style="color:#777;">
                        Order
                    </td>
                    <td align="right">
                        <strong>#{{ $order->id }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="color:#777;">
                        Delivered
                    </td>
                    <td align="right">
                        {{ now()->format('d M Y') }}
                    </td>
                </tr>

                <tr>
                    <td style="color:#777;">
                        Total
                    </td>
                    <td align="right">
                        <strong>
                            ₹{{ number_format($order->total_price, 2) }}
                        </strong>
                    </td>
                </tr>

            </table>

        </td>
    </tr>

    <!-- Greeting -->
    <tr>
        <td style="padding:0 30px 30px;">

            <p style="font-size:15px;line-height:1.6;">
                Hi {{ \Auth::user()->first_name.' '.\Auth::user()->last_name }},
            </p>

            <p style="font-size:15px;line-height:1.6;color:#555;">
                We hope you received your order safely and are happy
                with your purchase.
            </p>

            <p style="font-size:15px;line-height:1.6;color:#555;">
                Thank you for choosing Jamwal Motors and Spares.
            </p>

        </td>
    </tr>

    <!-- CTA -->
    <tr>
        <td style="text-align:center;padding-bottom:35px;">

            <a href="{{ url('/en') }}"
               style="display:inline-block;background:#e63946;
                      color:#fff;padding:13px 30px;
                      border-radius:6px;text-decoration:none;
                      font-weight:bold;" target="_blank">
                Continue Shopping
            </a>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8f8f8;text-align:center;padding:20px;">

            <p style="margin:0;font-size:12px;color:#888;">
                Need help? Contact Jamwal Motors and Spares.
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
