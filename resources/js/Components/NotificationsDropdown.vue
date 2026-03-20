<template>
    <div class="relative">
        <button
            @click="toggleDropdown"
            class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span
                v-if="unreadCount > 0"
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
            >
                {{ unreadCount > 99 ? '99+' : unreadCount }}
            </span>
        </button>

        <div
            v-if="isOpen"
            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border border-gray-200"
        >
            <div class="p-3 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Уведомления</h3>
                    <button
                        v-if="unreadCount > 0"
                        @click="markAllAsRead"
                        class="text-sm text-[#416081] hover:text-[#2c4a62]"
                    >
                        Все прочитано
                    </button>
                </div>
            </div>

            <div class="max-h-96 overflow-y-auto">
                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    @click="handleNotificationClick(notification)"
                    class="p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                    :class="{ 'bg-blue-50': !notification.read_at }"
                >
                    <div class="flex justify-between">
                        <h4 class="font-medium text-sm" :class="{ 'text-[#416081]': !notification.read_at }">
                            {{ notification.title }}
                        </h4>
                        <span class="text-xs text-gray-500">
                            {{ formatDate(notification.created_at) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ notification.message }}</p>
                </div>

                <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500">
                    Нет уведомлений
                </div>
            </div>

            <div class="p-2 border-t border-gray-200">
                <Link :href="route('notifications.index')" class="block text-center text-sm text-[#416081] py-1 hover:underline">
                    Все уведомления
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import axios from 'axios';

const isOpen = ref(false);
const unreadCount = ref(0);
const notifications = ref([]);

const fetchUnreadCount = async () => {
    try {
        const response = await axios.get('/notifications/unread-count');
        unreadCount.value = response.data.count;
    } catch (error) {
        console.error('Error fetching unread count:', error);
    }
};

const fetchRecentNotifications = async () => {
    try {
        const response = await axios.get('/notifications/recent');
        notifications.value = response.data;
    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
};

const markAsRead = async (id) => {
    try {
        await axios.post(`/notifications/${id}/read`);
        await fetchUnreadCount();
        await fetchRecentNotifications();
    } catch (error) {
        console.error('Error marking as read:', error);
    }
};

const markAllAsRead = async () => {
    try {
        await axios.post('/notifications/mark-all-read');
        await fetchUnreadCount();
        await fetchRecentNotifications();
    } catch (error) {
        console.error('Error marking all as read:', error);
    }
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        fetchRecentNotifications();
    }
};

const handleNotificationClick = (notification) => {
    if (!notification.read_at) {
        markAsRead(notification.id);
    }

    if (notification.action_url) {
        router.visit(notification.action_url);
    }
    isOpen.value = false;
};

const formatDate = (date) => {
    return new Date(date).toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
};

onMounted(() => {
    fetchUnreadCount();
    const interval = setInterval(fetchUnreadCount, 30000);
    onUnmounted(() => clearInterval(interval));
});
</script>
