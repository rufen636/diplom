<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

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

// Анимация появления элементов
const observer = ref(null);

onMounted(() => {
    observer.value = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.value.observe(el);
    });
});
</script>

<template>
    <Head title="WebContact Pro - Умное управление договорами" />

    <div class="min-h-screen bg-white overflow-hidden">
        <!-- Анимированный фон с частицами -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-[#4E89A5] rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-[#416081] rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-[#4E89A5] rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-[#4E89A5]/5 via-transparent to-[#416081]/5"></div>
        </div>

        <!-- Header с эффектом стекла -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Логотип с анимацией -->
                    <div class="flex items-center group cursor-pointer">
                        <div class="relative">
                            <div class="w-12 h-12 bg-[#4E89A5] rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-all duration-300 shadow-lg shadow-[#4E89A5]/25">
                                <svg class="w-7 h-7 text-white transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="absolute -inset-0.5 bg-[#4E89A5] rounded-xl blur opacity-30 group-hover:opacity-50 transition duration-1000"></div>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-2xl font-bold text-gray-900">
                                WebContact Pro
                            </h1>
                            <p class="text-xs text-gray-500 tracking-wider">УМНОЕ УПРАВЛЕНИЕ ДОГОВОРАМИ</p>
                        </div>
                    </div>

                    <!-- Навигация с эффектами -->
                    <nav class="hidden md:flex items-center space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-[#416081] transition-colors relative group">
                            Возможности
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#4E89A5] group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#how-it-works" class="text-gray-600 hover:text-[#416081] transition-colors relative group">
                            Как работает
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#4E89A5] group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#pricing" class="text-gray-600 hover:text-[#416081] transition-colors relative group">
                            Тарифы
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#4E89A5] group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </nav>

                    <!-- Кнопки авторизации -->
                    <div class="flex items-center space-x-4">
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="relative group px-6 py-2.5 rounded-xl overflow-hidden bg-[#4E89A5]"
                            >
                                <div class="absolute inset-0 bg-[#416081] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <span class="relative text-white font-medium">Панель управления</span>
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-gray-600 hover:text-[#416081] transition-colors px-4 py-2"
                            >
                                Вход
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="relative group px-6 py-2.5 rounded-xl overflow-hidden bg-[#4E89A5]"
                            >
                                <div class="absolute inset-0 bg-[#416081] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <span class="relative text-white font-medium">Регистрация</span>
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <main class="relative">
            <!-- Hero Section -->
            <div class="relative pt-32 pb-40 overflow-hidden">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center max-w-5xl mx-auto">
                        <!-- Бейдж -->
                        <div class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-full border border-gray-200 mb-8 animate-float">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></span>
                            <span class="text-sm text-gray-600">Новая версия 2.0 • Полностью автоматизировано</span>
                        </div>

                        <!-- Главный заголовок -->
                        <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold mb-8 text-gray-900">
                            Управляйте
                            <span class="text-[#4E89A5]">договорами</span>
                            как профессионал
                        </h1>

                        <!-- Описание -->
                        <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed animate-fade-in">
                            Интеллектуальная платформа для автоматизации договоров с клиентами.
                            Создавайте, подписывайте и храните документы в одном месте.
                        </p>

                        <!-- Кнопки -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-24">
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="group relative px-8 py-4 rounded-2xl overflow-hidden bg-[#4E89A5]"
                            >
                                <div class="absolute inset-0 bg-[#416081] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative flex items-center justify-center text-white text-lg font-semibold">
                                    Начать бесплатно
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </span>
                            </Link>
                            <Link
                                :href="route('login')"
                                class="group relative px-8 py-4 rounded-2xl overflow-hidden border border-gray-300 hover:border-[#4E89A5] transition-colors"
                            >
                                <div class="absolute inset-0 bg-gray-50/50"></div>
                                <span class="relative flex items-center justify-center text-gray-700 text-lg font-semibold">
                                    Смотреть демо
                                    <svg class="w-5 h-5 ml-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </Link>
                        </div>

                        <!-- Статистика -->
                        <!-- 3D карточки статистики -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                            <div class="group perspective">
                                <div class="relative preserve-3d group-hover:rotate-y-180 duration-1000 cursor-pointer">
                                    <div class="backface-hidden bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                                        <div class="text-4xl font-bold text-gray-900 mb-2">15K+</div>
                                        <div class="text-gray-500">Активных договоров</div>
                                    </div>
                                    <div class="absolute inset-0 backface-hidden rotate-y-180 bg-[#4E89A5] rounded-2xl p-6 flex items-center justify-center">
                                        <div class="text-white text-center">
                                            <div class="text-2xl font-bold mb-2">+127%</div>
                                            <div class="text-sm">рост за год</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="group perspective">
                                <div class="relative preserve-3d group-hover:rotate-y-180 duration-1000 cursor-pointer">
                                    <div class="backface-hidden bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                                        <div class="text-4xl font-bold text-gray-900 mb-2">500+</div>
                                        <div class="text-gray-500">Компаний доверяют</div>
                                    </div>
                                    <div class="absolute inset-0 backface-hidden rotate-y-180 bg-[#4E89A5] rounded-2xl p-6 flex items-center justify-center">
                                        <div class="text-white text-center">
                                            <div class="text-2xl font-bold mb-2">98%</div>
                                            <div class="text-sm">клиентов рекомендуют</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="group perspective">
                                <div class="relative preserve-3d group-hover:rotate-y-180 duration-1000 cursor-pointer">
                                    <div class="backface-hidden bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                                        <div class="text-4xl font-bold text-gray-900 mb-2">24/7</div>
                                        <div class="text-gray-500">Поддержка</div>
                                    </div>
                                    <div class="absolute inset-0 backface-hidden rotate-y-180 bg-[#4E89A5] rounded-2xl p-6 flex items-center justify-center">
                                        <div class="text-white text-center">
                                            <div class="text-2xl font-bold mb-2">5 мин</div>
                                            <div class="text-sm">среднее время ответа</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div id="features" class="relative py-32 bg-gray-50">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-20">
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 animate-on-scroll">
                            Возможности, которые
                            <span class="text-[#4E89A5]">меняют всё</span>
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto animate-on-scroll">
                            Мы объединили передовые технологии и удобство использования,
                            чтобы сделать работу с договорами максимально эффективной
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8">
                        <!-- Карточка 1 -->
                        <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-[#4E89A5] transition-all duration-500 transform hover:-translate-y-2 shadow-sm hover:shadow-md">
                            <div class="w-16 h-16 bg-[#4E89A5]/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-[#4E89A5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Умная CRM</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Единая база клиентов с автоматическим обновлением данных и историей взаимодействия
                            </p>
                        </div>

                        <!-- Карточка 2 -->
                        <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-[#4E89A5] transition-all duration-500 transform hover:-translate-y-2 shadow-sm hover:shadow-md">
                            <div class="w-16 h-16 bg-[#4E89A5]/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-[#4E89A5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Автоматизация</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Автоматическое создание, проверка и отправка договоров клиентам
                            </p>
                        </div>

                        <!-- Карточка 3 -->
                        <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-[#4E89A5] transition-all duration-500 transform hover:-translate-y-2 shadow-sm hover:shadow-md">
                            <div class="w-16 h-16 bg-[#4E89A5]/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-[#4E89A5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Интеграции</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Подключение к 1С, CRM, банкам и государственным сервисам
                            </p>
                        </div>

                        <!-- Карточка 4 -->
                        <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-[#4E89A5] transition-all duration-500 transform hover:-translate-y-2 shadow-sm hover:shadow-md">
                            <div class="w-16 h-16 bg-[#4E89A5]/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-[#4E89A5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Безопасность</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Шифрование данных и соответствие требованиям законодательства
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How It Works Section -->
            <div id="how-it-works" class="relative py-24 overflow-hidden">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Как работает
                            <span class="text-[#4E89A5]">система</span>
                        </h2>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                            Простой и понятный процесс управления договорами
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Шаг 1 -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:border-[#4E89A5] transition-all duration-300 shadow-sm">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-[#4E89A5] rounded-xl flex items-center justify-center">
                                    <span class="text-xl font-bold text-white">1</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Заявка</h3>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Клиент оставляет заявку на подключение через сайт или по телефону
                            </p>
                        </div>

                        <!-- Шаг 2 -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:border-[#4E89A5] transition-all duration-300 shadow-sm">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-[#4E89A5] rounded-xl flex items-center justify-center">
                                    <span class="text-xl font-bold text-white">2</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Проверка</h3>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Технический отдел проверяет возможность подключения по адресу
                            </p>
                        </div>

                        <!-- Шаг 3 -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:border-[#4E89A5] transition-all duration-300 shadow-sm">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-[#4E89A5] rounded-xl flex items-center justify-center">
                                    <span class="text-xl font-bold text-white">3</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Договор</h3>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Автоматическое формирование договора с подстановкой данных клиента
                            </p>
                        </div>

                        <!-- Шаг 4 -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:border-[#4E89A5] transition-all duration-300 shadow-sm">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-[#4E89A5] rounded-xl flex items-center justify-center">
                                    <span class="text-xl font-bold text-white">4</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Подключение</h3>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Подписание договора и активация услуги доступа в интернет
                            </p>
                        </div>
                    </div>

                    <!-- Кнопка действия -->
                    <div class="text-center mt-12">
                        <a href="#contact" class="inline-flex items-center gap-2 bg-[#4E89A5] hover:bg-[#416081] text-white font-medium px-8 py-3 rounded-xl transition-all duration-300">
                            Начать работу
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="relative py-32 bg-[#4E89A5]">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="max-w-4xl mx-auto text-center">
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                            Готовы к переменам?
                        </h2>
                        <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                            Присоединяйтесь к 500+ компаниям, которые уже автоматизировали работу с договорами
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="group relative px-10 py-5 bg-white rounded-2xl overflow-hidden"
                            >
                                <span class="relative text-lg font-bold text-[#4E89A5] group-hover:text-[#416081] transition-colors flex items-center">
                                    Начать 14-дневный триал
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </span>
                            </Link>
                            <Link
                                :href="route('login')"
                                class="px-10 py-5 border-2 border-white text-white text-lg rounded-2xl hover:bg-white/10 transition-all duration-300 font-semibold"
                            >
                                Запросить консультацию
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative bg-gray-900 pt-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-[#4E89A5] rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="ml-2 text-xl font-bold text-white">WebContact Pro</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Инновационная платформа для управления договорами
                        </p>
                    </div>

                    <div>
                        <h4 class="text-white font-bold mb-4">Продукт</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Возможности</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Тарифы</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Интеграции</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">API</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-bold mb-4">Компания</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">О нас</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Блог</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Карьера</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Контакты</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-bold mb-4">Правовая информация</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Политика конфиденциальности</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Условия использования</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-[#4E89A5] transition-colors">Согласие на обработку данных</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm mb-4 md:mb-0">
                        © {{ new Date().getFullYear() }} WebContact Pro. Все права защищены.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#4E89A5]/20 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#4E89A5] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#4E89A5]/20 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#4E89A5] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#4E89A5]/20 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#4E89A5] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
                    <p class="mt-1">Разработано с использованием Vue.js и Tailwind CSS</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
/* Анимации */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animate-on-scroll {
    opacity: 0;
}
/* 3D эффекты */
.perspective {
    perspective: 1000px;
}

.preserve-3d {
    transform-style: preserve-3d;
    transition: transform 0.6s;
}

.backface-hidden {
    backface-visibility: hidden;
}

.rotate-y-180 {
    transform: rotateY(180deg);
}

.group:hover .group-hover\:rotate-y-180 {
    transform: rotateY(180deg);
}
</style>
