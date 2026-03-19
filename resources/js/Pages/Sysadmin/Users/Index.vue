<template>
    <ManagerLayout title="Управление пользователями">
        <div class="card">
            <!-- Заголовок и кнопка создания -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Список пользователей</h3>
                <Link :href="route('manager.users.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Добавить пользователя
                </Link>
            </div>

            <!-- Поиск -->
            <div class="mb-6">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Поиск по имени или email..."
                    class="input-field"
                    @input="handleSearch"
                />
            </div>

            <!-- Таблица пользователей -->
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
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link
                                    :href="route('manager.users.edit', user.id)"
                                    class="text-[#4E89A5] hover:text-[#416081] mr-4"
                                >
                                    Редактировать
                                </Link>
                                <button
                                    @click="confirmDelete(user)"
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
                    Показано {{ users.from }} - {{ users.to }} из {{ users.total }} пользователей
                </div>
                <div class="flex space-x-2">
                    <Link
                        v-if="users.prev_page_url"
                        :href="users.prev_page_url"
                        class="btn-secondary"
                    >
                        Назад
                    </Link>
                    <Link
                        v-if="users.next_page_url"
                        :href="users.next_page_url"
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
                    Вы уверены, что хотите удалить пользователя <strong>{{ userToDelete?.name }}</strong>?
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">
                        Отмена
                    </button>
                    <button @click="deleteUser" class="btn-danger">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </ManagerLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

const props = defineProps({
    users: Object,
    filters: Object
});

const search = ref(props.filters.search || '');
const showDeleteModal = ref(false);
const userToDelete = ref(null);

function handleSearch() {
    router.get(route('manager.users.index'), { search: search.value }, {
        preserveState: true,
        replace: true
    });
}

function confirmDelete(user) {
    userToDelete.value = user;
    showDeleteModal.value = true;
}

function deleteUser() {
    if (userToDelete.value) {
        router.delete(route('manager.users.destroy', userToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                userToDelete.value = null;
            }
        });
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>

