<template>
    <ManagerLayout title="Управление тарифами">
        <div class="card">
            <!-- Заголовок и кнопка создания -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Список тарифов</h3>
                <Link :href="route('manager.tariffs.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Добавить тариф
                </Link>
            </div>

            <!-- Поиск и фильтры -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Поиск по названию или описанию..."
                    class="input-field"
                    @input="handleSearch"
                />
                <select v-model="statusFilter" @change="handleFilter" class="input-field">
                    <option value="">Все тарифы</option>
                    <option value="active">Активные</option>
                    <option value="inactive">Неактивные</option>
                </select>
            </div>

            <!-- Таблица тарифов -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Название
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Скорость
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Цена
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Срок
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
                        <tr v-for="tariff in tariffs.data" :key="tariff.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ tariff.name }}</div>
                                <div class="text-sm text-gray-500">{{ tariff.description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ tariff.speed }} Мбит/с</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-[#416081]">{{ formatPrice(tariff.price) }} ₽</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ tariff.duration_months }} мес.</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="tariff.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                >
                                    {{ tariff.is_active ? 'Активен' : 'Неактивен' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link
                                    :href="route('manager.tariffs.edit', tariff.id)"
                                    class="text-[#4E89A5] hover:text-[#416081] mr-4"
                                >
                                    Редактировать
                                </Link>
                                <button
                                    @click="confirmDelete(tariff)"
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
                    Показано {{ tariffs.from }} - {{ tariffs.to }} из {{ tariffs.total }} тарифов
                </div>
                <div class="flex space-x-2">
                    <Link
                        v-if="tariffs.prev_page_url"
                        :href="tariffs.prev_page_url"
                        class="btn-secondary"
                    >
                        Назад
                    </Link>
                    <Link
                        v-if="tariffs.next_page_url"
                        :href="tariffs.next_page_url"
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
                    Вы уверены, что хотите удалить тариф <strong>{{ tariffToDelete?.name }}</strong>?
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">
                        Отмена
                    </button>
                    <button @click="deleteTariff" class="btn-danger">
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
    tariffs: Object,
    filters: Object
});

const search = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || '');
const showDeleteModal = ref(false);
const tariffToDelete = ref(null);

function handleSearch() {
    router.get(route('manager.tariffs.index'), { search: search.value, status: statusFilter.value }, {
        preserveState: true,
        replace: true
    });
}

function handleFilter() {
    router.get(route('manager.tariffs.index'), { search: search.value, status: statusFilter.value }, {
        preserveState: true,
        replace: true
    });
}

function confirmDelete(tariff) {
    tariffToDelete.value = tariff;
    showDeleteModal.value = true;
}

function deleteTariff() {
    if (tariffToDelete.value) {
        router.delete(route('manager.tariffs.destroy', tariffToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                tariffToDelete.value = null;
            }
        });
    }
}

function formatPrice(price) {
    return new Intl.NumberFormat('ru-RU').format(price);
}
</script>

