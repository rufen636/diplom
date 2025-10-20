<template>
    <ManagerLayout title="Добавить клиента провайдера">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Создать нового клиента провайдера</h3>

                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <!-- Название компании -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Название компании <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.company_name"
                                type="text"
                                class="input-field"
                                :class="{ 'border-red-500': errors.company_name }"
                                placeholder="ООО 'Пример'"
                                required
                            />
                            <p v-if="errors.company_name" class="mt-1 text-sm text-red-600">{{ errors.company_name }}</p>
                        </div>

                        <!-- Контактное лицо -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Контактное лицо <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.contact_person"
                                type="text"
                                class="input-field"
                                :class="{ 'border-red-500': errors.contact_person }"
                                placeholder="Иванов Иван Иванович"
                                required
                            />
                            <p v-if="errors.contact_person" class="mt-1 text-sm text-red-600">{{ errors.contact_person }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="input-field"
                                :class="{ 'border-red-500': errors.email }"
                                placeholder="example@company.ru"
                                required
                            />
                            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                        </div>

                        <!-- Телефон -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Телефон <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.phone"
                                type="tel"
                                class="input-field"
                                :class="{ 'border-red-500': errors.phone }"
                                placeholder="+7 (999) 123-45-67"
                                required
                            />
                            <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
                        </div>

                        <!-- Адрес -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Адрес
                            </label>
                            <textarea
                                v-model="form.address"
                                rows="2"
                                class="input-field"
                                :class="{ 'border-red-500': errors.address }"
                                placeholder="г. Москва, ул. Примерная, д. 1"
                            ></textarea>
                            <p v-if="errors.address" class="mt-1 text-sm text-red-600">{{ errors.address }}</p>
                        </div>

                        <!-- ИНН и КПП -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    ИНН
                                </label>
                                <input
                                    v-model="form.inn"
                                    type="text"
                                    maxlength="12"
                                    class="input-field"
                                    :class="{ 'border-red-500': errors.inn }"
                                    placeholder="1234567890"
                                />
                                <p v-if="errors.inn" class="mt-1 text-sm text-red-600">{{ errors.inn }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    КПП
                                </label>
                                <input
                                    v-model="form.kpp"
                                    type="text"
                                    maxlength="9"
                                    class="input-field"
                                    :class="{ 'border-red-500': errors.kpp }"
                                    placeholder="123456789"
                                />
                                <p v-if="errors.kpp" class="mt-1 text-sm text-red-600">{{ errors.kpp }}</p>
                            </div>
                        </div>

                        <!-- Статус -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Статус <span class="text-red-500">*</span>
                            </label>
                            <select
                                v-model="form.status"
                                class="input-field"
                                :class="{ 'border-red-500': errors.status }"
                                required
                            >
                                <option value="active">Активен</option>
                                <option value="inactive">Неактивен</option>
                                <option value="blocked">Заблокирован</option>
                            </select>
                            <p v-if="errors.status" class="mt-1 text-sm text-red-600">{{ errors.status }}</p>
                        </div>

                        <!-- Заметки -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Заметки
                            </label>
                            <textarea
                                v-model="form.notes"
                                rows="3"
                                class="input-field"
                                :class="{ 'border-red-500': errors.notes }"
                                placeholder="Дополнительная информация о клиенте..."
                            ></textarea>
                            <p v-if="errors.notes" class="mt-1 text-sm text-red-600">{{ errors.notes }}</p>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <Link :href="route('manager.provider-clients.index')" class="btn-secondary">
                            Отмена
                        </Link>
                        <button type="submit" class="btn-primary" :disabled="processing">
                            {{ processing ? 'Создание...' : 'Создать клиента' }}
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

const form = useForm({
    company_name: '',
    contact_person: '',
    email: '',
    phone: '',
    address: '',
    inn: '',
    kpp: '',
    status: 'active',
    notes: ''
});

const props = defineProps({
    errors: Object
});

const processing = reactive({ value: false });

function submit() {
    processing.value = true;
    form.post(route('manager.provider-clients.store'), {
        onFinish: () => {
            processing.value = false;
        }
    });
}
</script>

