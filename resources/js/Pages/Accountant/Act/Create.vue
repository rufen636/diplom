<template>
    <AccountantLayout title="Сформировать акты">
        <div class="card">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Выберите оплаченные счета для формирования актов</h3>

            <form @submit.prevent="submit">
                <div v-if="billings.length === 0" class="text-gray-500 py-8 text-center">
                    Нет оплаченных счетов для формирования актов.
                </div>
                <div v-else class="space-y-2 mb-6">
                    <div
                        v-for="billing in billings"
                        :key="billing.id"
                        class="flex items-center p-4 border rounded-lg hover:bg-gray-50"
                    >
                        <input
                            :id="`billing-${billing.id}`"
                            v-model="selectedIds"
                            type="checkbox"
                            :value="billing.id"
                            class="rounded border-gray-300"
                        />
                        <label :for="`billing-${billing.id}`" class="ml-4 flex-1 cursor-pointer">
                            <span class="font-medium">{{ billing.billing_number }}</span>
                            — {{ billing.provider_client?.name ?? '-' }}
                            — {{ formatCurrency(billing.amount) }}
                            ({{ formatDate(billing.paid_date) }})
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <Link :href="route('accountant.acts.index')" class="btn-secondary">Отмена</Link>
                    <button
                        type="submit"
                        class="btn-primary"
                        :disabled="selectedIds.length === 0"
                    >
                        Сформировать акты ({{ selectedIds.length }})
                    </button>
                </div>
            </form>
        </div>
    </AccountantLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AccountantLayout from '@/Layouts/Accountant/AccountantLayout.vue';

const props = defineProps({
    billings: Array
});

const selectedIds = ref([]);

function submit() {
    router.post(route('accountant.acts.generate'), { billing_ids: selectedIds.value });
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('ru-RU');
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(amount ?? 0);
}
</script>
