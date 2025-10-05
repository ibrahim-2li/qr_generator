<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دفع آمن - Moyasar</title>
    <script src="https://cdn.moyasar.com/mpf/1.10.0/moyasar.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            margin: 0;
        }

        .payment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: #666;
        }

        .detail-value {
            font-weight: bold;
            color: #333;
        }

        .moyasar-form {
            margin-top: 20px;
        }

        .back-btn {
            display: inline-block;
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #5a6268;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <div class="header">
            <h1>دفع آمن</h1>
            <p>أكمل عملية الدفع بأمان</p>
        </div>

        <div class="payment-details">
            <div class="detail-row">
                <span class="detail-label">المبلغ:</span>
                <span class="detail-value">{{ number_format($paymentData['amount'] / 100, 2) }} ريال</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الوصف:</span>
                <span class="detail-value">{{ $paymentData['description'] }}</span>
            </div>
        </div>

        <div class="moyasar-form">
            <div id="moyasar-form"></div>
        </div>

        <a href="{{ route('filament.dashboard.pages.subscribe-page') }}" class="back-btn">العودة</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing Moyasar payment form...');
            console.log('Payment data:', @json($paymentData));

            try {
                Moyasar.init({
                    element: '#moyasar-form',
                    amount: {{ $paymentData['amount'] }},
                    currency: '{{ $paymentData['currency'] }}',
                    description: '{{ $paymentData['description'] }}',
                    publishable_api_key: '{{ config('services.moyasar.public') }}',
                    callback_url: '{{ $paymentData['callback_url'] }}',
                    metadata: @json($paymentData['metadata']),
                    methods: ['creditcard', 'mada', 'stcpay'],
                    on_completed: function(payment) {
                        console.log('Payment completed:', payment);
                        alert('تم الدفع بنجاح! سيتم توجيهك إلى صفحة التأكيد.');
                        window.location.href =
                            '{{ route('filament.dashboard.pages.my-subscription-page') }}';
                    },
                    on_failed: function(error) {
                        console.error('Payment failed:', error);
                        alert('فشل في عملية الدفع: ' + (error.message || 'خطأ غير معروف'));
                    }
                });
                console.log('Moyasar form initialized successfully');
            } catch (error) {
                console.error('Error initializing Moyasar form:', error);
                alert('خطأ في تحميل نموذج الدفع. يرجى المحاولة مرة أخرى.');
            }
        });
    </script>
</body>

</html>
