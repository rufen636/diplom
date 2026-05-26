<template>
    <SysadminLayout title="Оборудование">
        <div class="card">
            <!-- Заголовок и кнопка создания -->
            <div class="page-toolbar">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">Справочник оборудования</h3>
                <Link :href="route('sysadmin.equipment.create')" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Добавить оборудование
                </Link>
            </div>

            <div class="mb-6">
                <form @submit.prevent="handleSearch" class="flex gap-4">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Поиск по названию, MAC..."
                        class="input-field flex-1"
                    />
                    <button type="submit" class="btn-primary">Найти</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Описание</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">MAC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Услуги</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="item in equipmentData.data" :key="item.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ item.description || '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.mac_address || '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.ip_address || '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                                <span v-for="(svc, i) in (item.services || [])" :key="svc.id">
                                    {{ svc.name }}{{ i < (item.services?.length || 0) - 1 ? ', ' : '' }}
                                </span>
                            <span v-if="!item.services?.length">—</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <Link
                                :href="route('sysadmin.equipment.edit', item.id)"
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
                    <tr v-if="!equipmentData.data?.length">
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Оборудование не найдено</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Пагинация - используем paginationLinks с переводом -->
            <div v-if="paginationLinks.length > 0" class="mt-6 flex justify-center">
                <template v-for="(link, index) in paginationLinks" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="inline-block mx-1 px-3 py-1 border rounded transition-colors"
                        :class="link.active
                            ? 'bg-[#4E89A5] text-white border-[#4E89A5] cursor-default'
                            : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                    >
                        <span v-html="link.label"></span>
                    </Link>
                    <span
                        v-else
                        class="inline-block mx-1 px-3 py-1 bg-gray-100 border border-gray-200 text-gray-400 rounded cursor-not-allowed"
                        v-html="link.label"
                    ></span>
                </template>
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
                    Вы уверены, что хотите удалить оборудование "{{ equipmentToDelete?.name }}"?
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">Отмена</button>
                    <button @click="deleteEquipment" class="btn-danger">Удалить</button>
                </div>
            </div>
        </div>
    </SysadminLayout>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'
import axios from 'axios'

const props = defineProps({
    equipment: Object,
    filters: Object
})

const equipmentData = ref(props.equipment)
const search = ref(props.filters?.search || '')
const showDeleteModal = ref(false)
const equipmentToDelete = ref(null)

// Вычисляемое свойство для пагинации с переводом
const paginationLinks = computed(() => {
    // Проверяем где находятся links
    const links = equipmentData.value?.links ||
        equipmentData.value?.meta?.links ||
        []

    if (!links.length) return []

    return links.map(link => {
        let label = link.label

        // Замена английских названий на русские
        if (label === '&laquo; Previous' || label === 'Previous') {
            label = 'Пред.'
        } else if (label === 'Next &raquo;' || label === 'Next') {
            label = 'След.'
        } else if (label === '&laquo; First') {
            label = '« Первая'
        } else if (label === 'Last &raquo;') {
            label = 'Последняя »'
        }

        return { ...link, label }
    })
})

// Следим за обновлением пропсов
watch(() => props.equipment, (val) => {
    equipmentData.value = val
}, { deep: true })

// Функция поиска
function handleSearch() {
    router.get(route('sysadmin.equipment.index'), { search: search.value }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

// Подтверждение удаления
function confirmDelete(equipment) {
    equipmentToDelete.value = equipment
    showDeleteModal.value = true
}

// Удаление оборудования
function deleteEquipment() {
    if (equipmentToDelete.value) {
        axios.delete(route('sysadmin.equipment.destroy', equipmentToDelete.value.id))
            .then(() => {
                showDeleteModal.value = false
                equipmentToDelete.value = null
                handleSearch()
            })
            .catch(error => {
                console.error('Ошибка при удалении:', error)
                alert('Не удалось удалить оборудование')
            })
    }
}
</script>

<style scoped>
.card { @apply bg-white rounded-lg shadow p-6; }
.input-field { @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent; }
.btn-primary { @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] transition-colors; }
.btn-secondary { @apply bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors; }
.btn-danger { @apply bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors; }
</style>
