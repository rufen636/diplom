<template>
    <div class="card">
        <!-- Заголовок и кнопка создания -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-semibold text-gray-800">Список тарифов</h3>
            <Link :href="route('manager.service-requests.create')" class="btn-primary">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Добавить заявку
            </Link>
        </div>
<!--        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">-->
<!--            <input-->
<!--                v-model="search"-->
<!--                type="text"-->
<!--                placeholder="Поиск по названию, контакту, email или телефону..."-->
<!--                class="input-field"-->
<!--                @input="handleSearch"-->
<!--            />-->
<!--            <select v-model="statusFilter" @change="handleFilter" class="input-field">-->
<!--                <option value="">Все заявки</option>-->
<!--                <option value="active">Активные</option>-->
<!--                <option value="inactive">Неактивные</option>-->
<!--            </select>-->
<!--        </div>-->

        <!-- Таблица клиентов -->
<!--        <div class="overflow-x-auto">-->
<!--            <table class="min-w-full divide-y divide-gray-200">-->
<!--                <thead class="bg-gray-50">-->
<!--                <tr>-->
<!--                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                        Название заявки-->
<!--                    </th>-->
<!--                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                        Клиент-->
<!--                    </th>-->
<!--                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                        Статус-->
<!--                    </th>-->
<!--                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                        Действия-->
<!--                    </th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody class="bg-white divide-y divide-gray-200">-->
<!--                <tr v-for="client in clients.data" :key="client.id" class="hover:bg-gray-50">-->
<!--                    <td class="px-6 py-4 whitespace-nowrap">-->
<!--                        <div class="text-sm text-gray-900">{{ client.contact_person }}</div>-->
<!--                    </td>-->
<!--                    <td class="px-6 py-4 whitespace-nowrap">-->
<!--                        <div class="text-sm text-gray-500">{{ client.email }}</div>-->
<!--                    </td>-->
<!--                    <td class="px-6 py-4 whitespace-nowrap">-->
<!--                                <span-->
<!--                                    :class="{-->
<!--                                        'bg-green-100 text-green-800': client.status === 'active',-->
<!--                                        'bg-gray-100 text-gray-800': client.status === 'inactive',-->
<!--                                        'bg-red-100 text-red-800': client.status === 'blocked'-->
<!--                                    }"-->
<!--                                    class="px-2 py-1 text-xs font-semibold rounded-full"-->
<!--                                >-->
<!--                                    {{ getStatusLabel(client.status) }}-->
<!--                                </span>-->
<!--                    </td>-->
<!--                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">-->
<!--                        <Link-->
<!--                            :href="route('manager.provider-clients.edit', client.id)"-->
<!--                            class="text-[#4E89A5] hover:text-[#416081] mr-4"-->
<!--                        >-->
<!--                            Редактировать-->
<!--                        </Link>-->
<!--                        <button-->
<!--                            @click="confirmDelete(client)"-->
<!--                            class="text-[#B75D5D] hover:text-red-600"-->
<!--                        >-->
<!--                            Удалить-->
<!--                        </button>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @click="showDeleteModal = false"
        >
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Подтверждение удаления</h3>
                <p class="text-gray-600 mb-6">
                    Вы уверены, что хотите удалить зявку? <strong>{{ requestToDelete?.company_name }}</strong>?
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
<script lang="ts">
import {defineComponent} from 'vue'
import ManagerLayout from "@/Layouts/Manager/ManagerLayout.vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "Index",
    components: {Link},
    layout: ManagerLayout,
    data(){
        return {
            showDeleteModal: false,
            requestToDelete: null,
            search:''
        }
    },
    methods:{
        confirmDelete(client){
            this.requestToDelete.value = client;
            this.showDeleteModal.value = true;
        }
    },
    deleteRequest(){

    }
})
</script>
<style scoped>

</style>
