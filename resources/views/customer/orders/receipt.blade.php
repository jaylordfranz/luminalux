<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background: linear-gradient(to right, #ff0000, #ffff00); /* Gradient from red to yellow */
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff; /* White background for the receipt container */
        }
        .header, .footer {
            text-align: center;
            padding: 10px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #000;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .address {
            text-align: center;
            margin: 20px 0;
        }
        .order-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-details th, .order-details td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .order-details th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lumina Lux</h1>
            <p>Order Receipt</p>
        </div>
        
        <div class="address">
            <p>Taguig City, Metro Manila, Philippines</p>
        </div>
        
        <div class="order-details">
            <table>
                <tr>
                    <th>Order ID:</th>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <th>Date:</th>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Total Amount:</th>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for your purchase!</p>
            <p>Company Name: Lumina Lux</p>
            <p>Contact Info: contact@luminalux.com</p>
        </div>
    </div>
</body>
</html>
