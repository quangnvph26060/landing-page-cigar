<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đơn hàng mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
        }

        .info {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .info p {
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🛒 Thông báo yêu cầu đặt hàng mới</h2>
        <div class="info">
            <p><strong>👤 Tên khách hàng:</strong> {{ $contact->name }}</p>
            <p><strong>📞 Số điện thoại:</strong> {{ $contact->phone }}</p>

            <p><strong>🗺️ Địa chỉ:</strong>
                {{ $contact->address . ', ' . $contact->province->name . ', ' . $contact->district->name . ', ' . $contact->ward->name }}
            </p>

            @if ($contact->message)
                <p><strong>📝 Lời nhắn:</strong> {{ $contact->message }}</p>
            @endif
        </div>
        <div class="footer">
            <p><a href="{{ env('APP_URL') }}">Truy cập website</a> để biết thêm chi tiết.</p>
        </div>
    </div>
</body>

</html>
