<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="ContractFlow - Управление договорами" />

    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 shadow-sm">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    WebContact Pro
                                </h1>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Управление договорами</p>
                            </div>
                        </div>
                    </div>

                    <!-- Auth Links -->
                    <div class="flex items-center space-x-4">
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium text-sm"
                            >
                                Панель управления
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="px-4 py-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors font-medium text-sm"
                            >
                                Вход
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="px-5 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium text-sm shadow-md hover:shadow-lg"
                            >
                                Регистрация
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="pt-12 pb-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Main Hero -->
                <div class="text-center py-12 lg:py-20">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        <span class="block text-gray-900 dark:text-white">Программное средство</span>
                        <span class="block bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            управления договорами
                        </span>
                    </h1>

                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto leading-relaxed">
                        Автоматизированная система для работы с договорами на предоставление услуг
                        доступа к сети «Интернет» с физическими и юридическими лицами
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            Начать бесплатно
                        </Link>
                        <Link
                            :href="route('login')"
                            class="px-8 py-3 border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 text-lg rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300 font-semibold"
                        >
                            Демо доступ
                        </Link>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-3 gap-8 mb-20">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Клиентская база</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Управление договорами с физическими и юридическими лицами в единой системе
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Безопасность данных</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Шифрование и защита персональных данных в соответствии с законодательством
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Автоматизация</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Автоматическое создание, подписание и отслеживание статуса договоров
                        </p>
                    </div>
                </div>

                <!-- How It Works -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 mb-20">
                    <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Как это работает</h2>
                    <div class="grid md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">1</span>
                            </div>
                            <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Создание договора</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Заполнение шаблона договора на услуги интернета
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">2</span>
                            </div>
                            <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Согласование</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Электронное согласование с клиентом и юристом
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">3</span>
                            </div>
                            <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Подписание</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Электронная или физическая подпись документа
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">4</span>
                            </div>
                            <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Архивация</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Хранение и быстрый поиск договоров в архиве
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-12 text-white">
                    <h2 class="text-3xl font-bold mb-6">Готовы оптимизировать работу с договорами?</h2>
                    <p class="text-xl mb-8 text-blue-100">
                        Присоединяйтесь к компаниям, которые уже используют WebContact Pro
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-8 py-4 bg-white text-blue-600 text-lg rounded-xl hover:bg-gray-100 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl"
                        >
                            Начать 14-дневный пробный период
                        </Link>
                        <Link
                            :href="route('login')"
                            class="px-8 py-4 border-2 border-white text-white text-lg rounded-xl hover:bg-white/10 transition-all duration-300 font-semibold"
                        >
                            Запросить демонстрацию
                        </Link>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold">ContractFlow</span>
                        </div>
                        <p class="text-gray-400 text-sm mt-2">
                            Система управления договорами © {{ new Date().getFullYear() }}
                        </p>
                    </div>

                    <div class="text-gray-400 text-sm">
                        <p>Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
                        <p class="mt-1">Разработано с использованием Vue.js и Tailwind CSS</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
