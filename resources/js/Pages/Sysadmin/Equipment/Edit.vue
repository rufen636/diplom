<template>
    <SysadminLayout title="Редактировать оборудование">
        <div class="card max-w-2xl">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать оборудование</h3>

            <form @submit.prevent="submit">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Название <span class="text-red-500">*</span></label>
                        <input v-model="form.name" type="text" class="input-field w-full" required />
                        <p v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                        <textarea v-model="form.description" rows="2" class="input-field w-full"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">MAC-адрес</label>
                            <input v-model="form.mac_address" type="text" class="input-field w-full" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IP-адрес</label>
                            <input v-model="form.ip_address" type="text" class="input-field w-full" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Цена (₽)</label>
                        <input v-model="form.price" type="number" step="0.01" min="0" class="input-field w-full" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Услуги (для каких услуг подходит)</label>
                        <div class="border rounded-lg p-3 space-y-2 max-h-40 overflow-y-auto">
                            <label v-for="s in services" :key="s.id" class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" :value="s.id" v-model="form.service_ids" class="rounded" />
                                <span>{{ s.name }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <Link :href="route('sysadmin.equipment.index')" class="btn-secondary">Отмена</Link>
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        {{ form.processing ? 'Сохранение...' : 'Сохранить' }}
                    </button>
                </div>
            </form>
        </div>
    </SysadminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'

const props = defineProps({
    equipment: Object,
    services: Array
})

const form = useForm({
    name: props.equipment.name,
    description: props.equipment.description || '',
    mac_address: props.equipment.mac_address || '',
    ip_address: props.equipment.ip_address || '',
    price: props.equipment.price,
    service_ids: props.equipment.services?.map(s => s.id) || []
})

function submit() {
    form.put(route('sysadmin.equipment.update', props.equipment.id))
}
</script>

<style scoped>
.card { @apply bg-white rounded-lg shadow p-6; }
.input-field { @apply px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent; }
.btn-primary { @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] disabled:opacity-50; }
.btn-secondary { @apply bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600; }
</style>
