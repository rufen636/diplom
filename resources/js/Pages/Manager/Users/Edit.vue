<template>
    <ManagerLayout title="Редактировать пользователя">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать пользователя</h3>

                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <!-- Имя -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Имя
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

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="input-field"
                                :class="{ 'border-red-500': errors.email }"
                                required
                            />
                            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                        </div>

                        <!-- Пароль -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Новый пароль (оставьте пустым, чтобы не менять)
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                class="input-field"
                                :class="{ 'border-red-500': errors.password }"
                            />
                            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
                        </div>

                        <!-- Подтверждение пароля -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Подтверждение пароля
                            </label>
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="input-field"
                            />
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <Link :href="route('manager.users.index')" class="btn-secondary">
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
    user: Object,
    errors: Object
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: ''
});

const processing = reactive({ value: false });

function submit() {
    processing.value = true;
    form.put(route('manager.users.update', props.user.id), {
        onFinish: () => {
            processing.value = false;
        }
    });
}
</script>

