<template>
    <SysadminLayout title="Заявки на проверке">
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Заявки на проверке</h3>
                <div v-if="statistics" class="flex gap-4 text-sm">
                    <span class="text-blue-600">На проверке: {{ statistics.on_inspection }}</span>
                    <span class="text-green-600">С оборудованием: {{ statistics.equipment_assigned }}</span>
                </div>
            </div>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <input
                    v-model="filter.search"
                    type="text"
                    placeholder="Поиск по названию, адресу, клиенту..."
                    class="input-field"
                    @keyup.enter="applyFilter"
                />
                <select v-model="filter.status" @change="applyFilter" class="input-field">
                    <option value="">Все (на проверке + с оборудованием)</option>
                    <option value="on_inspection">На проверке</option>
                    <option value="equipment_assigned">Оборудование привязано</option>
                    <option value="accepted">Принята</option>
                    <option value="rejected">Отклонена</option>
                </select>
                <button @click="applyFilter" class="btn-primary">Найти</button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Адрес</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Клиент</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Оборудование</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="req in requestsData.data" :key="req.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ req.title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="statusClass(req.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                                    {{ getStatusLabel(req.status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ req.installation_address || '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ req.client_name || '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <span v-if="req.equipments?.length">{{ req.equipments.map(e => e.name).join(', ') }}</span>
                                <span v-else>—</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ req.created_at }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <button
                                    @click="openModal(req)"
                                    class="text-[#4E89A5] hover:text-[#416081]"
                                >
                                    Изменить статус / Привязать оборудование
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!requestsData.data?.length">
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Заявки не найдены
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="requestsData.meta?.links" class="mt-6 flex justify-center gap-2">
                <template v-for="(link, i) in requestsData.meta.links" :key="i">
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

        <!-- Модальное окно: статус + оборудование -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @click.self="closeModal"
        >
            <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Заявка: {{ selectedRequest?.title }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                        <select v-model="modalForm.status" class="input-field w-full">
                            <option value="on_inspection">На проверке</option>
                            <option value="accepted">Принята</option>
                            <option value="rejected">Отклонена</option>
                            <option value="equipment_assigned">Оборудование привязано</option>
                        </select>
                    </div>

                    <div v-if="modalForm.status === 'equipment_assigned'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Услуга (для фильтра оборудования)</label>
                        <select v-model="modalForm.service_id" class="input-field w-full" @change="loadEquipmentOptions(modalForm.service_id)">
                            <option value="">Всё оборудование</option>
                            <option v-for="s in services" :key="s.id" :value="s.id">{{ s.name }}</option>
                        </select>
                    </div>

                    <div v-if="modalForm.status === 'equipment_assigned'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Оборудование <span class="text-gray-500">(можно несколько)</span></label>
                        <div class="border rounded-lg p-3 max-h-40 overflow-y-auto space-y-2">
                            <label v-for="eq in equipmentOptions" :key="eq.id" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                <input type="checkbox" :value="eq.id" v-model="modalForm.equipment_ids" class="rounded" />
                                <span>{{ eq.name }}{{ eq.mac_address ? ' (' + eq.mac_address + ')' : '' }}</span>
                            </label>
                            <p v-if="!equipmentOptions.length" class="text-sm text-gray-500">Сначала выберите услугу или оставьте «Всё оборудование»</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Заметки (опционально)</label>
                        <textarea v-model="modalForm.notes" rows="2" class="input-field w-full"></textarea>
                    </div>

                    <p v-if="modalError" class="text-sm text-red-600">{{ modalError }}</p>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button @click="closeModal" class="btn-secondary">Отмена</button>
                    <button @click="saveModal" class="btn-primary" :disabled="saving">
                        {{ saving ? 'Сохранение...' : 'Сохранить' }}
                    </button>
                </div>
            </div>
        </div>
    </SysadminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import axios from 'axios'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'

const props = defineProps({
    requests: Object,
    filters: Object,
    services: { type: Array, default: () => [] },
    statistics: Object
})

const requestsData = ref(props.requests)
const filter = ref({
    search: props.filters?.search || '',
    status: props.filters?.status || ''
})

watch(() => props.requests, (v) => { requestsData.value = v }, { deep: true })

const showModal = ref(false)
const selectedRequest = ref(null)
const equipmentOptions = ref([])
const saving = ref(false)
const modalError = ref('')

const modalForm = ref({
    status: 'on_inspection',
    service_id: '',
    equipment_ids: [],
    notes: ''
})

function applyFilter() {
    router.get(route('sysadmin.service-requests.index'), filter.value, { preserveState: true })
}

function statusClass(status) {
    const m = {
        on_inspection: 'bg-blue-100 text-blue-800',
        equipment_assigned: 'bg-green-100 text-green-800',
        accepted: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800',
        archived: 'bg-gray-100 text-gray-800'
    }
    return m[status] || 'bg-gray-100 text-gray-800'
}

function getStatusLabel(status) {
    const labels = {
        created: 'Создана',
        accepted: 'Принята',
        on_inspection: 'На проверке',
        equipment_assigned: 'Оборудование привязано',
        archived: 'Архивирована',
        rejected: 'Отклонена'
    }
    return labels[status] || status
}

async function loadEquipmentOptions(serviceId) {
    if (!selectedRequest.value) return
    try {
        let url = route('sysadmin.service-requests.equipment-options', selectedRequest.value.id)
        if (serviceId) url += '?service_id=' + serviceId
        const res = await axios.get(url)
        equipmentOptions.value = res.data.equipment || []
    } catch {
        equipmentOptions.value = []
    }
}

async function openModal(req) {
    selectedRequest.value = req
    modalForm.value = {
        status: req.status,
        service_id: req.service_id || (req.service?.id || ''),
        equipment_ids: (req.equipments || []).map(e => e.id),
        notes: ''
    }
    modalError.value = ''
    showModal.value = true
    await loadEquipmentOptions(modalForm.value.service_id || '')
}

function closeModal() {
    showModal.value = false
    selectedRequest.value = null
}

async function saveModal() {
    if (!selectedRequest.value) return

    saving.value = true
    modalError.value = ''

    try {
        if (modalForm.value.status === 'equipment_assigned') {
            if (!modalForm.value.equipment_ids?.length) {
                modalError.value = 'Выберите хотя бы одно оборудование'
                saving.value = false
                return
            }
            const res = await axios.post(
                route('sysadmin.service-requests.assign-equipment', selectedRequest.value.id),
                {
                    equipment_ids: modalForm.value.equipment_ids,
                    notes: modalForm.value.notes
                },
                { headers: { 'Accept': 'application/json' } }
            )
            if (res.data?.success) {
                router.reload()
                closeModal()
            }
        } else if (modalForm.value.status !== 'equipment_assigned') {
            await axios.patch(
                route('sysadmin.service-requests.update-status', selectedRequest.value.id),
                { status: modalForm.value.status },
                { headers: { 'Accept': 'application/json' } }
            )
            router.reload()
            closeModal()
        }
    } catch (err) {
        modalError.value = err.response?.data?.error || err.response?.data?.message || 'Ошибка сохранения'
    } finally {
        saving.value = false
    }
}
</script>

<style scoped>
.card { @apply bg-white rounded-lg shadow p-6; }
.input-field { @apply px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent; }
.btn-primary { @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] disabled:opacity-50; }
.btn-secondary { @apply bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600; }
</style>
