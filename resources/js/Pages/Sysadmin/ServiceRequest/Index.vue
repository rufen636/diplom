<template>
    <div class="card">
        <!-- Заголовок и кнопка создания -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-semibold text-gray-800">Список заявок</h3>
            <Link :href="route('manager.service-requests.create')" class="btn-primary">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Добавить заявку
            </Link>
        </div>
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <input
                v-model="filter.search"
                type="text"
                placeholder="Поиск по названию или клиенту..."
                class="input-field"
                @input="showFilterRequest()"
            />

            <select v-model="filter.status" @change="showFilterRequest()" class="input-field">
                <option value="">Все статусы</option>
                <option value="created">Создана</option>
                <option value="accepted">Принята</option>
                <option value="on_inspection">На проверке</option>
                <option value="archived">Архивирована</option>
            </select>
        </div>

        <!-- Таблица заявок -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Название
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Статус
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Адрес Установки
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Имя клиента
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Дата создания
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Действия
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="request in requestsData.data" :key="request.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ request.title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="{
                                        'bg-green-100 text-green-800': request.status === 'accepted',
                                        'bg-gray-100 text-gray-800': request.status === 'archived',
                                        'bg-yellow-100 text-yellow-800': request.status === 'created',
                                        'bg-blue-100 text-blue-800': request.status === 'on_inspection'
                                    }"
                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                >
                                    {{ getStatusLabel(request.status) }}
                                </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ request.installation_address }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ request.client_name }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800"
                                >
                                   {{ request.created_at }}
                                </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <Link
                            :href="route('manager.service-requests.edit', request.id)"
                            class="text-[#4E89A5] hover:text-[#416081] mr-4"
                        >
                            Редактировать
                        </Link>
                        <button
                            @click="confirmDelete(request)"
                            class="text-[#B75D5D] hover:text-red-600"
                        >
                            Удалить
                        </button>
                    </td>
                </tr>
                <tr v-if="!requestsData.data?.length">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg">Заявки не найдены</p>
                        <p class="text-sm mt-2">Попробуйте изменить параметры поиска или создайте новую заявку</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        <div class="mt-6 flex justify-center">
            <template v-for="(link, index) in requestsData.meta.links" :key="index">
                <button
                    v-if="link.url"
                    @click="goToPage(link)"
                    class="inline-block mr-2 px-3 py-1 bg-white border border-gray-200 text-gray-700 rounded hover:bg-gray-50"
                    :class="{ 'bg-[#4E89A5] text-white': link.active }"
                    v-html="link.label"
                >
                </button>
                <span
                    v-else
                    class="inline-block mr-2 px-3 py-1 bg-gray-100 border border-gray-200 text-gray-400 rounded cursor-not-allowed"
                    v-html="link.label"
                ></span>
            </template>
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
                    Вы уверены, что хотите удалить заявку "{{ requestToDelete?.title }}"?
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">
                        Отмена
                    </button>
                    <button @click="deleteRequest" class="btn-danger">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import ManagerLayout from "@/Layouts/Manager/ManagerLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default defineComponent({
    name: "Index",
    components: {Link},
    layout: ManagerLayout,
    props:{
        serviceRequests: {
            type: Object,
            default: () => ({ data: [], meta: { links: [] } })
        }
    },
    data(){
        return {
            showDeleteModal: false,
            requestToDelete: null,
            requestsData: this.serviceRequests,
            filter: {
                search: '',
                status: '',
                page: 1,
                per_page: 10
            },
        }
    },
    watch: {
        'filter.search': {
            handler() {
                this.filter.page = 1;
                this.showFilterRequest();
            },
            deep: true
        },
        'filter.status': {
            handler() {
                this.filter.page = 1;
                this.showFilterRequest();
            },
            deep: true
        }
    },
    methods:{
        showFilterRequest() {
            console.log(this.filter);
            axios.get(route('manager.service-requests.index'), {
                params: this.filter
            }).then(res => {
                this.requestsData = res.data;
            }).catch(error => {
                console.error('Ошибка при загрузке:', error);
            });
        },

        goToPage(link) {
            if (link.url) {
                const urlParams = new URL(link.url);
                this.filter.page = urlParams.searchParams.get('page') || 1;
                this.showFilterRequest();
            }
        },

        confirmDelete(request) {
            this.requestToDelete = request;
            this.showDeleteModal = true;
        },

        deleteRequest() {
            if (this.requestToDelete) {
                axios.delete(route('manager.service-requests.destroy', this.requestToDelete.id))
                    .then(res => {
                        this.showDeleteModal = false;
                        this.requestToDelete = null;
                        // Обновляем список после удаления
                        this.showFilterRequest();
                    })
                    .catch(error => {
                        console.error('Ошибка при удалении:', error);
                    });
            }
        },

        getStatusLabel(status) {
            const labels = {
                'created': 'Создана',
                'accepted': 'Принята',
                'on_inspection': 'На проверке',
                'archived': 'Архивирована',
            };
            return labels[status] || status;
        }
    }
})
</script>

<style scoped>
.btn-primary {
    @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] transition-colors duration-200 flex items-center;
}
.btn-secondary {
    @apply bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors duration-200;
}
.btn-danger {
    @apply bg-[#B75D5D] text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200;
}
.input-field {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent outline-none transition-all duration-200;
}
</style>
