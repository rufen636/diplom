<template>
    <ManagerLayout title="Настройки">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Настройки системы</h3>

                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <!-- Название сайта -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Название сайта
                            </label>
                            <input
                                v-model="form.site_name"
                                type="text"
                                class="input-field"
                                :class="{ 'border-red-500': errors.site_name }"
                                required
                            />
                            <p v-if="errors.site_name" class="mt-1 text-sm text-red-600">{{ errors.site_name }}</p>
                        </div>

                        <!-- Email сайта -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email сайта
                            </label>
                            <input
                                v-model="form.site_email"
                                type="email"
                                class="input-field"
                                :class="{ 'border-red-500': errors.site_email }"
                                required
                            />
                            <p v-if="errors.site_email" class="mt-1 text-sm text-red-600">{{ errors.site_email }}</p>
                        </div>

                        <!-- Режим обслуживания -->
                        <div class="flex items-center">
                            <input
                                v-model="form.maintenance_mode"
                                type="checkbox"
                                class="w-4 h-4 text-[#416081] bg-gray-100 border-gray-300 rounded focus:ring-[#416081] focus:ring-2"
                            />
                            <label class="ml-2 text-sm font-medium text-gray-700">
                                Режим обслуживания
                            </label>
                        </div>
                    </div>

                    <!-- Кнопка сохранения -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="btn-primary" :disabled="processing">
                            {{ processing ? 'Сохранение...' : 'Сохранить настройки' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Информация о системе -->
            <div class="card mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Информация о системе</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">Версия PHP</span>
                        <span class="font-medium">{{ phpVersion }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">Версия Laravel</span>
                        <span class="font-medium">{{ laravelVersion }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">Окружение</span>
                        <span class="font-medium">{{ environment }}</span>
                    </div>
                </div>
            </div>
        </div>
    </ManagerLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

const props = defineProps({
    errors: Object,
    phpVersion: String,
    laravelVersion: String,
    environment: String
});

const form = useForm({
    site_name: 'Менеджер',
    site_email: 'admin@example.com',
    maintenance_mode: false
});

const processing = reactive({ value: false });

function submit() {
    processing.value = true;
    form.put(route('manager.settings.update'), {
        onFinish: () => {
            processing.value = false;
        }
    });
}
</script>

