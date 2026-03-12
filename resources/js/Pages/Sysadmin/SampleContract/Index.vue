<template>
    <ManagerLayout title="Управление шаблонами договоров">
        <div class="card">
            <!-- Заголовок и кнопка создания -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Список шаблонов договоров</h3>
                <Link :href="route('manager.sample-contracts.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Добавить шаблон
                </Link>
            </div>

            <!-- Поиск и фильтры -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <input
                    v-model="filter.search"
                    type="text"
                    placeholder="Поиск по названию или коду шаблона..."
                    class="input-field"
                    @input="showFilterPosts"
                />
                <select v-model="filter.contract_type" @change="showFilterPosts" class="input-field">
                    <option value="">Все типы договоров</option>
                    <option value="service">Сервисный</option>
                    <option value="sales">Продажи</option>
                    <option value="partnership">Партнерский</option>
                </select>
                <select v-model="filter.status" @change="showFilterPosts" class="input-field">
                    <option value="">Все статусы</option>
                    <option value="active">Активные</option>
                    <option value="inactive">Неактивные</option>
                    <option value="draft">Черновик</option>
                </select>
            </div>

            <!-- Таблица шаблонов -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Код шаблона
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Название
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Тип договора
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Версия
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Статус
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            По умолчанию
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="contract in contractsData.data" :key="contract.template_code" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ contract.template_code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="text-sm text-gray-900">{{ contract.name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ getContractTypeLabel(contract.contract_type) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">v{{ contract.version }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="{
                                        'bg-green-100 text-green-800': contract.status === 'active',
                                        'bg-gray-100 text-gray-800': contract.status === 'inactive',
                                        'bg-yellow-100 text-yellow-800': contract.status === 'draft'
                                    }"
                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                >
                                    {{ getStatusLabel(contract.status) }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    v-if="contract.is_default"
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800"
                                >
                                    По умолчанию
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <Link
                                :href="route('manager.sample-contracts.edit', contract.id)"
                                class="text-[#4E89A5] hover:text-[#416081] mr-4"
                            >
                                Редактировать
                            </Link>
                            <button
                                @click="confirmDelete(contract)"
                                class="text-[#B75D5D] hover:text-red-600"
                                :disabled="contract.is_default"
                                :class="{ 'opacity-50 cursor-not-allowed': contract.is_default }"
                            >
                                Удалить
                            </button>
                        </td>
                    </tr>
                    <tr v-if="!contractsData.data?.length">
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg">Шаблоны договоров не найдены</p>
                            <p class="text-sm mt-2">Попробуйте изменить параметры поиска или создайте новый шаблон</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Пагинация - как в примере -->
            <div class="mt-6">
                <a
                    href="#"
                    v-for="page in contractsData.meta.links"
                    class="inline-block mr-2 px-3 py-1 bg-white border border-gray-200 text-gray-700 rounded hover:bg-gray-50"
                    :class="{ 'bg-[green] text-white': page.active }"
                    v-html="page.label"
                    @click.prevent="filter.page = page.label; showFilterPosts(page.label)"
                >
                </a>
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
                    Вы уверены, что хотите удалить шаблон договора
                    <strong>{{ contractToDelete?.name }}</strong> ({{ contractToDelete?.template_code }})?
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

<script>
import { Link } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';
import axios from 'axios';

export default {
    name: 'SampleContractIndex',

    components: {
        ManagerLayout,
        Link
    },

    props: {
        sampleContracts: {
            type: Object,
            default: () => ({ data: [], meta: { links: [] } })
        }
    },

    data() {
        return {
            filter: {
                search: '',
                contract_type: '',
                status: '',
                page: '',
                per_page: 10
            },
            contractsData: this.sampleContracts,
            showDeleteModal: false,
            contractToDelete: null
        };
    },

    mounted() {
        console.log('Contracts data:', this.contractsData);
    },

    methods: {
        showFilterPosts(page) {
            // Обработка навигации по страницам
            if (page && page.includes('Previous') && this.contractsData.meta.current_page !== 1) {
                this.filter.page = Number(this.contractsData.meta.current_page) - 1;
            } else if (page && page.includes('Next') && this.contractsData.meta.current_page !== this.contractsData.meta.last_page) {
                this.filter.page = Number(this.contractsData.meta.current_page) + 1;
            } else if (page && !isNaN(page) && page !== '') {
                // Если это номер страницы
                this.filter.page = Number(page);
            } else if (page && (page.includes('Previous') || page.includes('Next'))) {
                return; // Выходим если это Previous/Next на границах
            }

            axios.get(route('manager.sample-contracts.index'), {
                params: this.filter
            }).then(res => {
                this.contractsData = res.data;
            });
        },

        confirmDelete(contract) {
            this.contractToDelete = contract;
            this.showDeleteModal = true;
        },

        deleteContract() {
            if (this.contractToDelete) {
                axios.delete(route('manager.sample-contracts.destroy', this.contractToDelete.template_code))
                    .then(res => {
                        this.showDeleteModal = false;
                        this.contractToDelete = null;
                        // Обновляем список после удаления
                        this.showFilterPosts();
                    })
                    .catch(error => {
                        console.error('Ошибка при удалении:', error);
                    });
            }
        },

        getContractTypeLabel(type) {
            const labels = {
                'service': 'Сервисный',
                'sales': 'Продажи',
                'partnership': 'Партнерский'
            };
            return labels[type] || type;
        },

        getStatusLabel(status) {
            const labels = {
                'active': 'Активен',
                'inactive': 'Неактивен',
                'draft': 'Черновик'
            };
            return labels[status] || status;
        }
    }
};
</script>
