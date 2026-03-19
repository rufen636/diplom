<template>
    <ManagerLayout title="Редактировать договор">
        <div class="max-w-3xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать договор</h3>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Номер договора -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Номер договора *
                            </label>
                            <input
                                v-model="form.contract_number"
                                type="text"
                                class="input-field"
                                :class="{ 'border-red-500': errors.contract_number }"
                                required
                            />
                            <p v-if="errors.contract_number" class="mt-1 text-sm text-red-600">{{ errors.contract_number }}</p>
                        </div>

                        <!-- Название договора -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Название договора *
                            </label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="input-field"
                                :class="{ 'border-red-500': errors.title }"
                                required
                            />
                            <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
                        </div>

                        <!-- Клиент -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Клиент *
                            </label>
                            <select
                                v-model="form.user_id"
                                class="input-field"
                                :class="{ 'border-red-500': errors.user_id }"
                                required
                            >
                                <option value="">Выберите клиента</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }} ({{ user.email }})
                                </option>
                            </select>
                            <p v-if="errors.user_id" class="mt-1 text-sm text-red-600">{{ errors.user_id }}</p>
                        </div>

                        <!-- Дата начала -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Дата начала *
                            </label>
                            <input
                                v-model="form.start_date"
                                type="date"
                                class="input-field"
                                :class="{ 'border-red-500': errors.start_date }"
                                required
                            />
                            <p v-if="errors.start_date" class="mt-1 text-sm text-red-600">{{ errors.start_date }}</p>
                        </div>

                        <!-- Дата окончания -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Дата окончания *
                            </label>
                            <input
                                v-model="form.end_date"
                                type="date"
                                class="input-field"
                                :class="{ 'border-red-500': errors.end_date }"
                                required
                            />
                            <p v-if="errors.end_date" class="mt-1 text-sm text-red-600">{{ errors.end_date }}</p>
                        </div>

                        <!-- Сумма -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Сумма (₽) *
                            </label>
                            <input
                                v-model="form.amount"
                                type="number"
                                step="0.01"
                                min="0"
                                class="input-field"
                                :class="{ 'border-red-500': errors.amount }"
                                required
                            />
                            <p v-if="errors.amount" class="mt-1 text-sm text-red-600">{{ errors.amount }}</p>
                        </div>

                        <!-- Статус -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Статус *
                            </label>
                            <select
                                v-model="form.status"
                                class="input-field"
                                :class="{ 'border-red-500': errors.status }"
                                required
                            >
                                <option value="active">Активный</option>
                                <option value="completed">Завершен</option>
                                <option value="terminated">Расторгнут</option>
                            </select>
                            <p v-if="errors.status" class="mt-1 text-sm text-red-600">{{ errors.status }}</p>
                        </div>

                        <!-- Описание -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Описание
                            </label>
                            <textarea
                                v-model="form.description"
                                rows="4"
                                class="input-field"
                                :class="{ 'border-red-500': errors.description }"
                            ></textarea>
                            <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <Link :href="route('manager.contracts.index')" class="btn-secondary">
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
    contract: Object,
    users: Array,
    errors: Object
});

const form = useForm({
    contract_number: props.contract.contract_number,
    title: props.contract.title,
    user_id: props.contract.user_id,
    start_date: props.contract.start_date,
    end_date: props.contract.end_date,
    amount: props.contract.amount,
    status: props.contract.status,
    description: props.contract.description || ''
});

const processing = reactive({ value: false });

function submit() {
    processing.value = true;
    form.put(route('manager.contracts.update', props.contract.id), {
        onFinish: () => {
            processing.value = false;
        }
    });
}
</script>

