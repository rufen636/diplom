<template>
    <AccountantLayout title="Счета">
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Список счетов</h3>
                <Link :href="route('accountant.billing.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Выставить счёт
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Поиск по номеру или клиенту..."
                    class="input-field"
                    @input="handleSearch"
                />
                <select v-model="statusFilter" class="input-field" @change="handleFilter">
                    <option value="">Все статусы</option>
                    <option value="created">Создан</option>
                    <option value="pending">Ожидает</option>
                    <option value="paid">Оплачен</option>
                    <option value="completed">Завершён</option>
                    <option value="expired">Истёк</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Номер</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Клиент</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сумма</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="billing in billings.data" :key="billing.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#416081">
                                {{ billing.billing_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ billing.provider_client?.name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                {{ formatCurrency(billing.amount) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ formatDate(billing.billing_date) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="getStatusColor(billing.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                                    {{ getStatusLabel(billing.status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <select
                                    v-if="billing.status !== 'paid' && billing.status !== 'completed'"
                                    :value="billing.status"
                                    class="input-field py-1 px-2 text-sm w-32"
                                    @change="updateStatus(billing, $event.target.value)"
                                >
                                    <option value="pending">Ожидает</option>
                                    <option value="paid">Оплачен</option>
                                    <option value="expired">Истёк</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Показано {{ billings.from ?? 0 }} - {{ billings.to ?? 0 }} из {{ billings.total ?? 0 }}
                </div>
                <div class="flex space-x-2">
                    <Link v-if="billings.prev_page_url" :href="billings.prev_page_url" class="btn-secondary">Назад</Link>
                    <Link v-if="billings.next_page_url" :href="billings.next_page_url" class="btn-secondary">Вперед</Link>
                </div>
            </div>
        </div>
    </AccountantLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AccountantLayout from '@/Layouts/Accountant/AccountantLayout.vue';

const props = defineProps({
    billings: Object,
    filters: Object
});

const search = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');

function handleSearch() {
    router.get(route('accountant.billing.index'), { search: search.value, status: statusFilter.value }, {
        preserveState: true,
        replace: true
    });
}

function handleFilter() {
    router.get(route('accountant.billing.index'), { search: search.value, status: statusFilter.value }, {
        preserveState: true,
        replace: true
    });
}

function updateStatus(billing, status) {
    router.patch(route('accountant.billing.updateStatus', billing.id), { status }, {
        preserveScroll: true
    });
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('ru-RU');
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(amount ?? 0);
}

function getStatusLabel(status) {
    const labels = { created: 'Создан', pending: 'Ожидает', paid: 'Оплачен', completed: 'Завершён', expired: 'Истёк' };
    return labels[status] || status;
}

function getStatusColor(status) {
    const colors = {
        created: 'bg-gray-100 text-gray-800',
        pending: 'bg-yellow-100 text-yellow-800',
        paid: 'bg-green-100 text-green-800',
        completed: 'bg-blue-100 text-blue-800',
        expired: 'bg-red-100 text-red-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
}
</script>
