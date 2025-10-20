<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-[#416081] mb-4">Добро пожаловать!</h3>
                            <p class="text-gray-600 mb-6">Вы успешно вошли в систему.</p>
                            <Link
                                :href="route('manager.dashboard')"
                                class="inline-block btn-primary"
                            >
                                Перейти в панель менеджера
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
