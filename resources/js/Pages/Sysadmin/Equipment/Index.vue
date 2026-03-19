<template>
    <SysadminLayout title="Оборудование">
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Справочник оборудования</h3>
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
                        </tr>
                        <tr v-if="!equipmentData.data?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Оборудование не найдено</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="equipmentData.meta?.links" class="mt-6 flex justify-center gap-2">
                <template v-for="(link, i) in equipmentData.meta.links" :key="i">
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
        </div>
    </SysadminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'

const props = defineProps({
    equipment: Object,
    filters: Object
})

const equipmentData = ref(props.equipment)
const search = ref(props.filters?.search || '')

watch(() => props.equipment, (val) => { equipmentData.value = val }, { deep: true })

function handleSearch() {
    router.get(route('sysadmin.equipment.index'), { search: search.value }, { preserveState: true })
}
</script>

<style scoped>
.card { @apply bg-white rounded-lg shadow p-6; }
.input-field { @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent; }
.btn-primary { @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] transition-colors; }
</style>
