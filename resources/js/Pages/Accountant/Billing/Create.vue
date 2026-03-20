<template>
    <AccountantLayout title="Выставить счёт">
        <div class="max-w-3xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Новый счёт</h3>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Договор *</label>
                            <select
                                v-model="form.contract_id"
                                class="input-field"
                                :class="{ 'border-red-500': errors.contract_id }"
                                required
                            >
                                <option value="">Выберите договор</option>
                                <option v-for="c in contracts" :key="c.id" :value="c.id">
                                    {{ c.contract_number }} — {{ c.provider_client?.name ?? '-' }}
                                </option>
                            </select>
                            <p v-if="errors.contract_id" class="mt-1 text-sm text-red-600">{{ errors.contract_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Тариф *</label>
                            <select
                                v-model="form.tariff_id"
                                class="input-field"
                                :class="{ 'border-red-500': errors.tariff_id }"
                                required
                            >
                                <option value="">Выберите тариф</option>
                                <option v-for="t in tariffs" :key="t.id" :value="t.id">
                                    {{ t.name }} — {{ formatCurrency(t.price) }}
                                </option>
                            </select>
                            <p v-if="errors.tariff_id" class="mt-1 text-sm text-red-600">{{ errors.tariff_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Сумма (₽) *</label>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Период с</label>
                            <input v-model="form.period_start" type="date" class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Период по</label>
                            <input v-model="form.period_end" type="date" class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Срок оплаты</label>
                            <input v-model="form.due_date" type="date" class="input-field" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Описание</label>
                            <textarea v-model="form.description" rows="3" class="input-field"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <Link :href="route('accountant.billing.index')" class="btn-secondary">Отмена</Link>
                        <button type="submit" class="btn-primary">Создать счёт</button>
                    </div>
                </form>
            </div>
        </div>
    </AccountantLayout>
</template>

<script setup>
import { router, Link, useForm } from '@inertiajs/vue3';
import AccountantLayout from '@/Layouts/Accountant/AccountantLayout.vue';

const props = defineProps({
    contracts: Array,
    tariffs: Array,
    errors: Object
});

const form = useForm({
    contract_id: '',
    tariff_id: '',
    amount: '',
    description: '',
    period_start: '',
    period_end: '',
    due_date: ''
});

function submit() {
    form.post(route('accountant.billing.store'));
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(amount ?? 0);
}
</script>
