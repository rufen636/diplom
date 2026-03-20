<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выставлен счёт</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 p-4">
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">📄 Выставлен счёт</h1>
                <p class="text-blue-100 mt-1">Бухгалтерия выставила новый счёт</p>
            </div>
        </div>
    </div>

    <div class="px-8 py-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6">
            <p class="text-sm text-blue-700 font-medium">👤 Клиент</p>
            <p class="text-lg font-semibold text-gray-800">{{ $clientName ?? '-' }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Счёт №{{ $billing->billing_number }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">💰 Сумма</p>
                    <p class="font-medium text-gray-800">{{ number_format($billing->amount, 2) }} ₽</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📅 Дата выставления</p>
                    <p class="font-medium text-gray-800">{{ $billing->billing_date?->format('d.m.Y') ?? '-' }}</p>
                </div>
                @if($billing->contract)
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">📋 Договор</p>
                        <p class="font-medium text-gray-800">{{ $billing->contract->contract_number ?? '-' }} — {{ $billing->contract->title ?? '-' }}</p>
                    </div>
                @endif
                @if($billing->description)
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">📝 Описание</p>
                        <p class="font-medium text-gray-800">{{ $billing->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
