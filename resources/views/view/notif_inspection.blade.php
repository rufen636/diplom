<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка на проверку</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 p-4">
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header with gradient -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">🔍 Новая заявка на проверку</h1>
                <p class="text-blue-100 mt-1">Требуется ваша оценка</p>
            </div>
            <div class="bg-white/20 rounded-full p-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-8 py-6">
        <!-- Client Info -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6">
            <p class="text-sm text-blue-700 font-medium">👤 Клиент</p>
            <p class="text-lg font-semibold text-gray-800">{{ $clientName ?? 'Не указан' }}</p>
        </div>

        <!-- Request Details -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Детали заявки #{{ $serviceRequest->id }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📋 Название</p>
                    <p class="font-medium text-gray-800">{{ $serviceRequest->title }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📌 Статус</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            На проверке
                        </span>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                    <p class="text-sm text-gray-500 mb-1">📝 Описание</p>
                    <p class="text-gray-800">{{ $serviceRequest->description ?: 'Нет описания' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📍 Адрес установки</p>
                    <p class="font-medium text-gray-800">{{ $serviceRequest->installation_address ?: 'Не указан' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">📅 Дата создания</p>
                    <p class="font-medium text-gray-800">{{ $serviceRequest->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Service Info -->
        @if($serviceRequest->service)
            <div class="mt-6 bg-purple-50 rounded-lg p-4">
                <h3 class="font-semibold text-purple-800 mb-2">🔧 Услуга</h3>
                <p class="text-purple-700">{{ $serviceRequest->service->name }}</p>
            </div>
        @endif

        <!-- Action Buttons -->
{{--        <div class="mt-8 flex flex-col sm:flex-row gap-4">--}}
{{--            <a href="{{ route('tech.service-requests.show', $serviceRequest->id) }}"--}}
{{--               class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">--}}
{{--                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>--}}
{{--                </svg>--}}
{{--                Просмотреть заявку--}}
{{--            </a>--}}

{{--            <a href="{{ route('tech.service-requests.index', ['status' => 'inspection']) }}"--}}
{{--               class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all">--}}
{{--                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>--}}
{{--                </svg>--}}
{{--                Все заявки--}}
{{--            </a>--}}
{{--        </div>--}}

        <!-- Quick Actions -->
{{--        <div class="mt-6 grid grid-cols-2 gap-3">--}}
{{--            <form action="{{ route('tech.service-requests.approve', $serviceRequest->id) }}" method="POST" class="inline">--}}
{{--                @csrf--}}
{{--                @method('PATCH')--}}
{{--                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-50 text-green-700 text-sm font-medium rounded-lg hover:bg-green-100 transition-all">--}}
{{--                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>--}}
{{--                    </svg>--}}
{{--                    Одобрить--}}
{{--                </button>--}}
{{--            </form>--}}

{{--            <form action="{{ route('tech.service-requests.reject', $serviceRequest->id) }}" method="POST" class="inline">--}}
{{--                @csrf--}}
{{--                @method('PATCH')--}}
{{--                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 transition-all">--}}
{{--                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>--}}
{{--                    </svg>--}}
{{--                    Отклонить--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        </div>--}}
    </div>

    <!-- Footer -->
    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                support@company.com
            </div>
        </div>
    </div>
</div>

</body>
</html>
