<template>
    <ManagerLayout title="Dashboard">
        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
            <!-- Пользователи -->
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Всего пользователей</p>
                        <p class="text-3xl font-bold text-[#416081] mt-2">{{ stats.totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#416081] bg-opacity-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#416081]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Активные пользователи</p>
                        <p class="text-3xl font-bold text-[#4E89A5] mt-2">{{ stats.activeUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#4E89A5] bg-opacity-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#4E89A5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Новых за месяц</p>
                        <p class="text-3xl font-bold text-[#8F9C9B] mt-2">{{ stats.newUsersThisMonth }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#8F9C9B] bg-opacity-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#8F9C9B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Договоры -->
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Всего договоров</p>
                        <p class="text-3xl font-bold text-[#416081] mt-2">{{ stats.totalContracts }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#416081] bg-opacity-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#416081]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Активных договоров</p>
                        <p class="text-3xl font-bold text-[#4E89A5] mt-2">{{ stats.activeContracts }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#4E89A5] bg-opacity-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#4E89A5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Общая сумма</p>
                        <p class="text-sm font-bold text-[#B75D5D] mt-10">{{ formatCurrency(stats.totalAmount) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#B75D5D] bg-opacity-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#B75D5D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Аналитика -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Динамика новых договоров</h3>
                <div class="h-72">
                    <canvas ref="contractsTrendCanvas"></canvas>
                </div>
            </div>

            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Динамика выручки</h3>
                <div class="h-72">
                    <canvas ref="revenueTrendCanvas"></canvas>
                </div>
            </div>

            <div class="card xl:col-span-2">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Распределение договоров по статусам</h3>
                <div class="h-80 max-w-lg mx-auto">
                    <canvas ref="statusDistributionCanvas"></canvas>
                </div>
            </div>
        </div>

        <!-- Отчетность -->
        <div class="card mb-8">
            <div class="page-toolbar">
                <h3 class="text-xl font-semibold text-gray-800">Отчетность</h3>
                <Link :href="route('manager.contracts.index')" class="btn-secondary">
                    Перейти к договорам
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-lg bg-[#416081]/10">
                    <p class="text-xs uppercase tracking-wide text-gray-600">Конверсия в активные</p>
                    <p class="text-2xl font-bold text-[#416081] mt-2">{{ activeContractsRate }}%</p>
                </div>
                <div class="p-4 rounded-lg bg-[#4E89A5]/10">
                    <p class="text-xs uppercase tracking-wide text-gray-600">Средний чек договора</p>
                    <p class="text-2xl font-bold text-[#4E89A5] mt-2">{{ averageContractAmount }}</p>
                </div>
                <div class="p-4 rounded-lg bg-[#8F9C9B]/10">
                    <p class="text-xs uppercase tracking-wide text-gray-600">Новых пользователей (30 дн.)</p>
                    <p class="text-2xl font-bold text-[#8F9C9B] mt-2">{{ stats.newUsersThisMonth }}</p>
                </div>
                <div class="p-4 rounded-lg bg-[#B75D5D]/10">
                    <p class="text-xs uppercase tracking-wide text-gray-600">Выручка за 6 месяцев</p>
                    <p class="text-2xl font-bold text-[#B75D5D] mt-2">{{ lastSixMonthsRevenue }}</p>
                </div>
            </div>
        </div>

        <!-- Последние договоры -->
        <div class="card mb-8">
            <div class="page-toolbar">
                <h3 class="text-xl font-semibold text-gray-800">Последние договоры</h3>
                <Link :href="route('manager.contracts.index')" class="btn-secondary">
                    Все договоры
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Номер
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Название
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Клиент
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Сумма
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Статус
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="contract in recentContracts" :key="contract.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#416081]">{{ contract.contract_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ contract.title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ formatCurrency(contract.amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="getStatusColor(contract.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                                    {{ getStatusLabel(contract.status) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Последние пользователи -->
        <div class="card">
            <div class="page-toolbar">
                <h3 class="text-xl font-semibold text-gray-800">Последние пользователи</h3>
                <Link :href="route('manager.users.index')" class="btn-secondary">
                    Все пользователи
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Пользователь
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Дата регистрации
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in recentUsers" :key="user.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-[#4E89A5] flex items-center justify-center text-white font-semibold">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ user.email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ formatDate(user.created_at) }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </ManagerLayout>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Chart, registerables } from 'chart.js';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

Chart.register(...registerables);

const props = defineProps({
    stats: Object,
    recentUsers: Array,
    recentContracts: Array,
    analytics: Object
});

const contractsTrendCanvas = ref(null);
const revenueTrendCanvas = ref(null);
const statusDistributionCanvas = ref(null);

let contractsTrendChart = null;
let revenueTrendChart = null;
let statusDistributionChart = null;

const activeContractsRate = computed(() => {
    if (!props.stats?.totalContracts) {
        return '0.0';
    }

    return ((props.stats.activeContracts / props.stats.totalContracts) * 100).toFixed(1);
});

const averageContractAmount = computed(() => {
    if (!props.stats?.totalContracts) {
        return formatCurrency(0);
    }

    return formatCurrency(props.stats.totalAmount / props.stats.totalContracts);
});

const lastSixMonthsRevenue = computed(() => {
    const revenue = (props.analytics?.monthlyRevenue?.data || []).reduce((acc, value) => acc + Number(value), 0);
    return formatCurrency(revenue);
});

function createContractsTrendChart() {
    if (!contractsTrendCanvas.value || !props.analytics?.monthlyContracts) {
        return;
    }

    contractsTrendChart = new Chart(contractsTrendCanvas.value, {
        type: 'line',
        data: {
            labels: props.analytics.monthlyContracts.labels,
            datasets: [
                {
                    label: 'Новые договоры',
                    data: props.analytics.monthlyContracts.data,
                    borderColor: '#416081',
                    backgroundColor: 'rgba(65, 96, 129, 0.18)',
                    tension: 0.35,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function createRevenueTrendChart() {
    if (!revenueTrendCanvas.value || !props.analytics?.monthlyRevenue) {
        return;
    }

    revenueTrendChart = new Chart(revenueTrendCanvas.value, {
        type: 'bar',
        data: {
            labels: props.analytics.monthlyRevenue.labels,
            datasets: [
                {
                    label: 'Выручка, RUB',
                    data: props.analytics.monthlyRevenue.data,
                    backgroundColor: '#4E89A5'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function createStatusDistributionChart() {
    if (!statusDistributionCanvas.value || !props.analytics?.contractStatus) {
        return;
    }

    statusDistributionChart = new Chart(statusDistributionCanvas.value, {
        type: 'doughnut',
        data: {
            labels: props.analytics.contractStatus.labels,
            datasets: [
                {
                    data: props.analytics.contractStatus.data,
                    backgroundColor: ['#4E89A5', '#8F9C9B', '#B75D5D']
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

onMounted(async () => {
    await nextTick();
    createContractsTrendChart();
    createRevenueTrendChart();
    createStatusDistributionChart();
});

onBeforeUnmount(() => {
    contractsTrendChart?.destroy();
    revenueTrendChart?.destroy();
    statusDistributionChart?.destroy();
});

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB'
    }).format(amount);
}

function getStatusLabel(status) {
    const labels = {
        'active': 'Активный',
        'completed': 'Завершен',
        'terminated': 'Расторгнут'
    };
    return labels[status] || status;
}

function getStatusColor(status) {
    const colors = {
        'active': 'bg-green-100 text-green-800',
        'completed': 'bg-blue-100 text-blue-800',
        'terminated': 'bg-red-100 text-red-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
}
</script>

