<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оборудование привязано к заявке</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 p-4">
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">✓ Оборудование назначено</h1>
                <p class="text-green-100 mt-1">Заявка готова к оформлению</p>
            </div>
        </div>
    </div>

    <div class="px-8 py-6">
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6">
            <p class="text-sm text-green-700 font-medium">👤 Клиент</p>
            <p class="text-lg font-semibold text-gray-800">{{ $clientName ?? 'Не указан' }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Заявка #{{ $serviceRequest->id }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📋 Название</p>
                    <p class="font-medium text-gray-800">{{ $serviceRequest->title }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📍 Адрес установки</p>
                    <p class="font-medium text-gray-800">{{ $serviceRequest->installation_address ?: 'Не указан' }}</p>
                </div>
            </div>
        </div>

        @if($serviceRequest->equipments->isNotEmpty())
            <div class="mt-6 bg-teal-50 rounded-lg p-4">
                <h3 class="font-semibold text-teal-800 mb-2">🔧 Назначенное оборудование</h3>
                <ul class="list-disc list-inside text-teal-700 space-y-1">
                    @foreach($serviceRequest->equipments as $eq)
                        <li>{{ $eq->name }}{{ $eq->mac_address ? ' (MAC: ' . $eq->mac_address . ')' : '' }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
</body>
</html>
