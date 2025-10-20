<template>
    <ManagerLayout title="Управление договорами">
        <div class="card">
            <!-- Заголовок и кнопка создания -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Список договоров</h3>
                <Link :href="route('manager.contracts.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Добавить договор
                </Link>
            </div>

            <!-- Фильтры -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Поиск по номеру, названию или клиенту..."
                        class="input-field"
                        @input="handleSearch"
                    />
                </div>
                <div>
                    <select
                        v-model="statusFilter"
                        class="input-field"
                        @change="handleFilter"
                    >
                        <option value="">Все статусы</option>
                        <option value="active">Активные</option>
                        <option value="completed">Завершенные</option>
                        <option value="terminated">Расторгнутые</option>
                    </select>
                </div>
            </div>

            <!-- Таблица договоров -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Номер договора
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Название
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Клиент
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Период
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Сумма
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Статус
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="contract in contracts.data" :key="contract.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#416081]">{{ contract.contract_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ contract.title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#4E89A5] flex items-center justify-center text-white text-xs font-semibold">
                                        {{ contract.user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ contract.user.name }}</div>
                                        <div class="text-xs text-gray-500">{{ contract.user.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ formatDate(contract.start_date) }} - {{ formatDate(contract.end_date) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ formatCurrency(contract.amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="getStatusColor(contract.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                                    {{ getStatusLabel(contract.status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link
                                    :href="route('manager.contracts.edit', contract.id)"
                                    class="text-[#4E89A5] hover:text-[#416081] mr-4"
                                >
                                    Редактировать
                                </Link>
                                <button
                                    @click="confirmDelete(contract)"
                                    class="text-[#B75D5D] hover:text-red-600"
                                >
                                    Удалить
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Показано {{ contracts.from }} - {{ contracts.to }} из {{ contracts.total }} договоров
                </div>
                <div class="flex space-x-2">
                    <Link
                        v-if="contracts.prev_page_url"
                        :href="contracts.prev_page_url"
                        class="btn-secondary"
                    >
                        Назад
                    </Link>
                    <Link
                        v-if="contracts.next_page_url"
                        :href="contracts.next_page_url"
                        class="btn-secondary"
                    >
                        Вперед
                    </Link>
                </div>
            </div>
        </div>

        <!-- Модальное окно подтверждения удаления -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @click="showDeleteModal = false"
        >
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Подтверждение удаления</h3>
                <p class="text-gray-600 mb-6">
                    Вы уверены, что хотите удалить договор <strong>{{ contractToDelete?.contract_number }}</strong>?
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">
                        Отмена
                    </button>
                    <button @click="deleteContract" class="btn-danger">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </ManagerLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

const props = defineProps({
    contracts: Object,
    filters: Object
});

const search = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || '');
const showDeleteModal = ref(false);
const contractToDelete = ref(null);

function handleSearch() {
    router.get(route('manager.contracts.index'), { search: search.value, status: statusFilter.value }, {
        preserveState: true,
        replace: true
    });
}

function handleFilter() {
    router.get(route('manager.contracts.index'), { search: search.value, status: statusFilter.value }, {
        preserveState: true,
        replace: true
    });
}

function confirmDelete(contract) {
    contractToDelete.value = contract;
    showDeleteModal.value = true;
}

function deleteContract() {
    if (contractToDelete.value) {
        router.delete(route('manager.contracts.destroy', contractToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                contractToDelete.value = null;
            }
        });
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
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

