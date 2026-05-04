<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
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
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
