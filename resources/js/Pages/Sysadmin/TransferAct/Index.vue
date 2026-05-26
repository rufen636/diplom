<template>
    <SysadminLayout title="Оборудование">
        <div class="card">
            <div class="page-toolbar">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">Справочник оборудования</h3>
                <Link :href="route('sysadmin.fixed-equipments.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Добавить акт
                </Link>
            </div>

            <div class="mb-6">
                <form @submit.prevent="handleSearch" class="flex gap-4">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Поиск"
                        class="input-field flex-1"
                    />
                    <button type="submit" class="btn-primary">Найти</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Номер акта</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Адрес установки</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Истекает</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in transferActData.data" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.act_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ item.installation_address || '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.status || '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.expiration_date || '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link
                                    @click="downloadPdf(item)"
                                    class="text-green-500 hover:text-[#416081] mr-4"
                                >Скачать акт</Link>
                                <Link
                                    :href="route('sysadmin.fixed-equipments.edit', item.id)"
                                    class="text-[#4E89A5] hover:text-[#416081] mr-4"
                                >
                                    Редактировать
                                </Link>
                                <button
                                    @click="confirmDelete(item)"
                                    class="text-[#B75D5D] hover:text-red-600"
                                >
                                    Удалить
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!transferActData.data?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Актов не найдено</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="transferActData.meta?.links" class="mt-6 flex justify-center gap-2">
                <template v-for="(link, i) in transferActData.meta.links" :key="i">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="px-3 py-1 rounded border"
                        :class="link.active ? 'bg-[#4E89A5] text-white border-[#4E89A5]' : 'border-gray-300 hover:bg-gray-50'"
                        v-html="link.label"
                    />
                    <span v-else class="px-3 py-1 text-gray-400" v-html="link.label"></span>
                </template>
            </div>
            <div
                v-if="showDeleteModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                @click="showDeleteModal = false"
            >
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Подтверждение удаления</h3>
                    <p class="text-gray-600 mb-6">
                        Вы уверены, что хотите удалить акт "{{ actToDelete?.act_number }}"?
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button @click="showDeleteModal = false" class="btn-secondary">
                            Отмена
                        </button>
                        <button @click="deleteAct" class="btn-danger">
                            Удалить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </SysadminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'
import axios from "axios";

const props = defineProps({
    transferActs: Object,
    filters: Object
})
const actToDelete = ref(null);
const showDeleteModal = ref(false);
function confirmDelete(act) {
    actToDelete.value = act;      // было: this.actToDelete = act;
    showDeleteModal.value = true;  // было: this.showDeleteModal = true;
}
function downloadPdf(item) {
    window.open(route('sysadmin.generateAct', item.id), '_blank');
}

function deleteAct() {
    if (actToDelete.value) {
        console.log('Удаление акта с ID:', actToDelete.value.id);

        router.delete(route('sysadmin.fixed-equipments.destroy', actToDelete.value.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                console.log('Удаление успешно');
                showDeleteModal.value = false;
                actToDelete.value = null;
                handleSearch();
            },
            onError: (errors) => {
                console.error('Ошибка при удалении:', errors);
                alert('Не удалось удалить акт');
            }
        });
    }
}

watch(() => props.transferActs, (val) => {
    transferActData.value = val
}, { deep: true })

const transferActData = ref(props.transferActs)
const search = ref(props.filters?.search || '')

watch(() => props.transferActs, (val) => { transferActData.value = val }, { deep: true })

function handleSearch() {
    router.get(route('sysadmin.fixed-equipments.index'), { search: search.value }, { preserveState: true })
}
</script>

<style scoped>
.card { @apply bg-white rounded-lg shadow p-6; }
.input-field { @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent; }
.btn-primary { @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] transition-colors; }
</style>
