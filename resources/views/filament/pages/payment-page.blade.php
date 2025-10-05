<x-filament::page>
    <div class="max-w-md mx-auto mt-10 p-6 border rounded-xl bg-white shadow">
        <h2 class="text-xl font-bold mb-4 text-center">
            إتمام الدفع لخطة: {{ $this->plan->name ?? 'غير محددة' }}
        </h2>

        <p class="text-center text-gray-500 mb-4">
            المبلغ: <strong>{{ number_format(($this->plan->price ?? 0) / 100, 2) }} ريال</strong>
        </p>
        <a href="{{ route('payment.page', $this->plan->id) }}"
            class="mt-4 block bg-primary-600 text-white text-center py-2 rounded-lg hover:bg-primary-700">
            اشترك الآن
        </a>


        <div id="moyasar-payment-form"></div>
    </div>

    <script src="https://cdn.moyasar.com/mpf/1.5.7/moyasar.js"></script>
    <script>
        Moyasar.init({
            element: '#moyasar-payment-form',
            amount: {{ $this->plan->price ?? 0 }},
            currency: 'SAR',
            description: 'اشتراك في خطة {{ $this->plan->name ?? '' }}',
            publishable_api_key: '{{ config('services.moyasar.public') }}',
            callback_url: '{{ $this->paymentCallbackUrl }}',
            methods: ['creditcard', 'applepay'],
            apple_pay: {
                country: 'SA',
                label: 'اشتراك ميسر',
            },
        });
    </script>
</x-filament::page>
