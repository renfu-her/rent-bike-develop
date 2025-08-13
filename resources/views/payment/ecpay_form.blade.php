<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>綠界金流付款 - 機車出租網站</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #28a745;
            margin-bottom: 10px;
        }
        .loading {
            text-align: center;
            padding: 40px 0;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-credit-card"></i> 綠界金流付款</h1>
            <p>正在導向綠界金流付款頁面，請稍候...</p>
        </div>

        <div class="loading">
            <div class="spinner"></div>
            <p>正在準備付款資訊...</p>
        </div>

        <div class="info">
            <p><strong>重要提醒：</strong></p>
            <p>• 請勿關閉此頁面，系統將自動導向綠界金流</p>
            <p>• 付款完成後將自動返回網站</p>
            <p>• 如有問題請聯繫客服</p>
        </div>

        <!-- 綠界金流表單 -->
        <form id="ecpayForm" method="POST" action="{{ $paymentUrl }}" style="display: none;">
            @foreach($params as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>

        <script>
            // 自動提交表單
            window.onload = function() {
                setTimeout(function() {
                    document.getElementById('ecpayForm').submit();
                }, 2000);
            };
        </script>
    </div>
</body>
</html>
