
<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-[#416081]">
                    <h1 class="text-white text-xl font-bold">Админ</h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <Link
                        :href="route('sysadmin.dashboard')"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith('/sysadmin/dashboard') }"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </Link>

<!--                    <Link-->
<!--                        :href="route('sysadmin.users.index')"-->
<!--                        class="nav-link"-->
<!--                        :class="{ active: $page.url.startsWith('/sysadmin/users') }"-->
<!--                    >-->
<!--                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />-->
<!--                        </svg>-->
<!--                        Пользователи-->
<!--                    </Link>-->
                    <Link
                        :href="route('sysadmin.service-requests.index')"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith('/sysadmin/service-requests') }"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Заявки на проверке
                    </Link>

                    <Link
                        :href="route('sysadmin.network-map.index')"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith('/sysadmin/network-map') }"
                    >
                        <svg class="w-5 h-5 mr-3" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6H12.01M9 20L3 17V4L5 5M9 20L15 17M9 20V14M15 17L21 20V7L19 6M15 17V14M15 6.2C15 7.96731 13.5 9.4 12 11C10.5 9.4 9 7.96731 9 6.2C9 4.43269 10.3431 3 12 3C13.6569 3 15 4.43269 15 6.2Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Карта покрытия
                    </Link>

                    <Link
                        :href="route('sysadmin.equipment.index')"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith('/sysadmin/equipment') }"
                    >
                        <svg  fill="#000000" width="800px" height="800px" viewBox="0 0 24 24" id="router-5" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color w-5 h-5 mr-3"><path id="primary" d="M5,9H19a1,1,0,0,1,1,1V20a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V10A1,1,0,0,1,5,9ZM8,4V9" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><line id="secondary" x1="14" y1="13" x2="16" y2="13" style="fill: none; stroke: rgb(44, 169, 188); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></line><line id="secondary-upstroke" x1="8.05" y1="3.5" x2="7.95" y2="3.5" style="fill: none; stroke: rgb(44, 169, 188); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></line></svg>
                        Оборудование
                    </Link>


                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-[#4E89A5] flex items-center justify-center text-white font-semibold">
                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                            </div>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $page.props.auth.user.name }}
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ $page.props.auth.user.email }}
                            </p>
                        </div>
                    </div>
                    <Link
                        :href="route('logout')"
                        method="post"
                        class="mt-3 w-full btn-danger text-center block"
                    >
                        Выйти
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="pl-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="px-8 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ title }}</h2>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'Системный администратор'
    }
});
</script>
<style scoped>
</style>
