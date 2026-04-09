<template>
    <ManagerLayout title="Редактировать акт">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать акт</h3>

                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <!-- Название -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Дата установки
                            </label>
                            <input
                                v-model="form.transfer_date"
                                type="date"
                                class="input-field"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                            <select v-model="form.status" class="input-field w-full">
                                <option value="draft">Черновик</option>
                                <option value="pending">В ожидании</option>
                                <option value="signed">Подписано</option>
                                <option value="completed">Выполнен</option>
                                <option value="completed">Отменен</option>
                            </select>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <Link :href="route('sysadmin.fixed-equipments.index')" class="btn-secondary">
                            Отмена
                        </Link>
                        <button type="submit" class="btn-primary" >
                            {{ 'Сохранить изменения' }}
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
    transferAct: Object,
});

const form = useForm({
    status: props.transferAct.status,
    transfer_date: props.transferAct.transfer_date,


});

const processing = reactive({ value: false });

function submit() {
    processing.value = true;
    form.put(route('sysadmin.fixed-equipments.update', props.transferAct.id), {
        onFinish: () => {
            processing.value = false;
            router.visit(route('sysadmin.fixed-equipments.index'))
        }
    });
}
</script>

