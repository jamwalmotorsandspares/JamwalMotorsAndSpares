<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Jamwal Motors and Spares</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;color:#222;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5;padding:30px 10px;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0"
       style="max-width:600px;width:100%;background:#ffffff;border-radius:10px;overflow:hidden;">

    <!-- Header -->
    <tr>
        <td style="background:#111827;padding:22px;text-align:center;">
            <h1 style="margin:0;color:#ffffff;font-size:24px;">
                Jamwal Motors & Spares
            </h1>
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:35px 30px;">

            <h2 style="margin:0 0 12px;font-size:24px;">
                Welcome, {{ $customer->name }}! 👋
            </h2>

            <p style="font-size:15px;line-height:1.6;color:#555;">
                Your account has been successfully created.
                You're now ready to discover genuine automotive spare parts
                from Jamwal Motors and Spares.
            </p>

            <div style="text-align:center;margin:30px 0;">
                <a href="https://jamwalmotorsandspares.shop/en"
                   style="display:inline-block;background:#e63946;color:#fff;
                          padding:13px 28px;border-radius:6px;
                          text-decoration:none;font-weight:bold;"  target="_blank">
                    Start Shopping
                </a>
            </div>

            <p style="font-size:14px;color:#777;line-height:1.6;">
                Thank you for choosing Jamwal Motors and Spares.
                We look forward to serving you.
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8f8f8;padding:20px;text-align:center;">
            <p style="margin:0;font-size:12px;color:#888;">
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
