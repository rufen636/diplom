<template>
    <AccountantLayout title="Акты">
        <div class="card">
            <div class="page-toolbar">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">Список актов</h3>
                <Link :href="route('accountant.acts.create')" class="btn-primary">
                    Сформировать акты из оплаченных счетов
                </Link>
            </div>

            <div class="mb-6">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Поиск по номеру или клиенту..."
                    class="input-field max-w-md"
                    @input="handleSearch"
                />
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
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="act in acts.data" :key="act.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#416081">
                                {{ act.act_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ act.provider_client?.name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                {{ formatCurrency(act.amount) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ formatDate(act.act_date) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ act.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="page-pagination">
                <div class="text-sm text-gray-700">
                    Показано {{ acts.from ?? 0 }} - {{ acts.to ?? 0 }} из {{ acts.total ?? 0 }}
                </div>
                <div class="flex space-x-2">
                    <Link v-if="acts.prev_page_url" :href="acts.prev_page_url" class="btn-secondary">Назад</Link>
                    <Link v-if="acts.next_page_url" :href="acts.next_page_url" class="btn-secondary">Вперед</Link>
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
    acts: Object,
    filters: Object
});

const search = ref(props.filters?.search || '');

function handleSearch() {
    router.get(route('accountant.acts.index'), { search: search.value }, {
        preserveState: true,
        replace: true
    });
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('ru-RU');
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(amount ?? 0);
}
</script>
