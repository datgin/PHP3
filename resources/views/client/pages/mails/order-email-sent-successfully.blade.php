<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
    }

    .order-success-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .order-success-card {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 400px;
        width: 100%;
    }

    .icon-container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #4CAF50;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 20px;
    }

    .icon {
        fill: white;
        width: 40px;
        height: 40px;
    }

    h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    p {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #45A049;
    }
</style>

<body>
    <div class="order-success-container">
        <div class="order-success-card">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.59l-3.59-3.59L8 12l3 3 7-7 1.41 1.42L11 16.59z" />
                </svg>
            </div>
            <h1>Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được xử lý thành công.</p>
            <a href="{{ route('home') }}" class="btn">Tiếp tục mua sắm</a>
        </div>
    </div>
</body>

</html>
