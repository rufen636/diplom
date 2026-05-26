<template>
    <SidebarShell :title="title" brand="Бухгалтер">
        <template #nav>
            <Link
                :href="route('accountant.billing.index')"
                class="nav-link"
                :class="{ active: $page.url.startsWith('/accountant/billing') }"
            >
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                </svg>
                Счета
            </Link>

            <Link
                :href="route('accountant.acts.index')"
                class="nav-link"
                :class="{ active: $page.url.startsWith('/accountant/acts') }"
            >
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Акты
            </Link>
        </template>

        <template #footer>
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
        </template>

        <template #header-actions>
            <NotificationsDropdown />
        </template>

        <slot />
    </SidebarShell>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import NotificationsDropdown from '@/Components/NotificationsDropdown.vue';
import SidebarShell from '@/Layouts/Partials/SidebarShell.vue';

defineProps({
    title: {
        type: String,
        default: 'Бухгалтер',
    },
});
</script>
