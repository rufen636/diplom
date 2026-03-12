<template>
    <ManagerLayout title="Редактировать тариф">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать тариф</h3>

                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <!-- Название -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Название тарифа <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="input-field"
                                :class="{ 'border-red-500': errors.name }"
                                required
                            />
                            <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                        </div>

                        <!-- Описание -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Описание
                            </label>
                            <textarea
                                v-model="form.description"
                                rows="3"
                                class="input-field"
                                :class="{ 'border-red-500': errors.description }"
                            ></textarea>
                            <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                        </div>

                        <!-- Цена -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Цена (₽) <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.price"
                                type="number"
                                step="0.01"
                                min="0"
                                class="input-field"
                                :class="{ 'border-red-500': errors.price }"
                                required
                            />
                            <p v-if="errors.price" class="mt-1 text-sm text-red-600">{{ errors.price }}</p>
                        </div>

                        <!-- Скорость -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Скорость (Мбит/с) <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.speed"
                                type="number"
                                min="1"
                                class="input-field"
                                :class="{ 'border-red-500': errors.speed }"
                                required
                            />
                            <p v-if="errors.speed" class="mt-1 text-sm text-red-600">{{ errors.speed }}</p>
                        </div>

                        <!-- Срок действия -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Срок действия (месяцев) <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.duration_months"
                                type="number"
                                min="1"
                                class="input-field"
                                :class="{ 'border-red-500': errors.duration_months }"
                                required
                            />
                            <p v-if="errors.duration_months" class="mt-1 text-sm text-red-600">{{ errors.duration_months }}</p>
                        </div>

                        <!-- Порядок сортировки -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Порядок сортировки
                            </label>
                            <input
                                v-model="form.sort_order"
                                type="number"
                                min="0"
                                class="input-field"
                                :class="{ 'border-red-500': errors.sort_order }"
                            />
                            <p v-if="errors.sort_order" class="mt-1 text-sm text-red-600">{{ errors.sort_order }}</p>
                        </div>

                        <!-- Статус -->
                        <div>
                            <label class="flex items-center">
                                <input
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-[#416081] focus:ring-[#416081]"
                                />
                                <span class="ml-2 text-sm text-gray-700">Тариф активен</span>
                            </label>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <Link :href="route('manager.tariffs.index')" class="btn-secondary">
                            Отмена
                        </Link>
                        <button type="submit" class="btn-primary" :disabled="processing">
                            {{ processing ? 'Сохранение...' : 'Сохранить изменения' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ManagerLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { router, Link, useForm } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

const props = defineProps({
    tariff: Object,
    errors: Object
});

const form = useForm({
    name: props.tariff.name,
    description: props.tariff.description,
    price: props.tariff.price,
    speed: props.tariff.speed,
    duration_months: props.tariff.duration_months,
    is_active: props.tariff.is_active,
    sort_order: props.tariff.sort_order
});

const processing = reactive({ value: false });

function submit() {
    processing.value = true;
    form.put(route('manager.tariffs.update', props.tariff.id), {
        onFinish: () => {
            processing.value = false;
        }
    });
}
</script>

