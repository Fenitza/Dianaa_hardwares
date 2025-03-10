<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Order Request</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eeeeee;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .email-header {
            background: #00457c; /* Change this to match your company colors */
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .email-body {
            padding: 20px;
            text-align: left;
            line-height: 1.5;
        }
        .email-footer {
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
            color: #777777;
        }
        h1 {
            color: #00457c; /* Your brand color for titles */
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <img src="http://127.0.0.1:8000/images/logo/Diana_logo2.png" alt="Company Logo" class="logo">
        Bulk Order Request
    </div>
    <div class="email-body">
        <h1>Hello Admin,</h1>
        <p>A bulk order request has been made with the following details:</p>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tbody>
                <tr style="background-color: #f4f4f4;">
                    <td style="padding: 10px; border: 1px solid #dddddd;"><strong>Product</strong></td>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $product_name ?? 'N/A' }}</td>
                </tr>
                <tr style="background-color: #f4f4f4;">
                    <td style="padding: 10px; border: 1px solid #dddddd;"><strong>SKU</strong></td>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $sku ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #dddddd;"><strong>Quantity</strong></td>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $quantity }}</td>
                </tr>
                <tr style="background-color: #f4f4f4;">
                    <td style="padding: 10px; border: 1px solid #dddddd;"><strong>Message</strong></td>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $emailMessage }}</td>
                </tr>
            </tbody>
        </table>
        <p>Contact details:</p>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tbody>
                <tr style="background-color: #f4f4f4;">
                    <td style="padding: 10px; border: 1px solid #dddddd;"><strong>Email</strong></td>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $userEmail }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #dddddd;"><strong>Phone</strong></td>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $userPhone }}</td>
                </tr>
            </tbody>
        </table>
        <p>Please review the request and contact customer for further processess.</p>
    </div>
    <div class="email-footer">
        Thank you for using our services!
    </div>
</div>
</html>