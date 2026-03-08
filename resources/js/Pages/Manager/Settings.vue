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
            <div class="card mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Информация о провайдере</h3>

                <form @submit.prevent="updateDetail">
                    <div class="space-y-4">
                        <!-- Название сайта -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                               Наименование провайдера
                            </label>
                            <input
                                v-model="formDetail.full_name"
                                type="text"
                                class="input-field"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Юридический адрес
                            </label>
                            <input
                                v-model="formDetail.legal_address"
                                type="text"
                                class="input-field"
                                @change="sameAddress"
                                required
                            />
                        </div>
                        <div class="flex items-center space-x-2">
                            <input
                                type="checkbox"
                                id="check-address"
                                v-model="isAddressSame"
                                @change="checkAddress"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                            >
                            <label for="check-address" class="text-sm font-medium text-gray-700 cursor-pointer">
                                Совпадает с юридическим?
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Фактический адрес
                            </label>
                            <input
                                v-model="formDetail.actual_address"
                                type="text"
                                class="input-field"

                                required
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Телефон
                            </label>
                            <input
                                v-model="formDetail.phone"
                                type="text"
                                class="input-field"

                                required
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Почта провайдера
                            </label>
                            <input
                                v-model="formDetail.email"
                                type="email"
                                class="input-field"

                                required
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                               Банковские реквизиты
                            </label>
                            <textarea
                                v-model="formDetail.bank_details"
                                type="text"
                                class="input-field"
                                required
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Веб-сайт провайдера
                            </label>
                            <input
                                v-model="formDetail.website"
                                type="text"
                                class="input-field"

                                required
                            />
                        </div>
                    </div>

                    <!-- Кнопка сохранения -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="btn-primary" :disabled="processing">
                            {{ processing ? 'Сохранение...' : 'Сохранить' }}
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
import {computed, reactive} from 'vue';
import { useForm } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    errors: Object,
    phpVersion: String,
    laravelVersion: String,
    environment: String,
    detail:Object
});
document.addEventListener('DOMContentLoaded',function (){
    console.log(props.detail);
})


const form = useForm({
    site_name: 'Менеджер',
    site_email: 'admin@example.com',
    maintenance_mode: false
});

const formDetail = useForm({
    full_name: props.detail?.full_name || '',
    legal_address: props.detail?.legal_address || '',
    actual_address: props.detail?.actual_address || '',
    phone: props.detail?.phone || '',
    email: props.detail?.email || '',
    bank_details: props.detail?.bank_details || '',
    website: props.detail?.website || '',
    isAddressSame: false
});
function  checkAddress() {
    if (this.isAddressSame) {
        formDetail.legal_address = formDetail.actual_address;
    } else {
        formDetail.legal_address = '';
    }
}
const processing =  false ;

function updateDetail(){
    formDetail.patch(route('manager.provider.details'),{
        onFinish: () => {
            this.processing = false;
        }
    })
}
function sameAddress() {
    formDetail.actual_address = formDetail.legal_address;

    if (formDetail.isAddressSame) {
        formDetail.legal_address = formDetail.actual_address;
    }
}
function submit() {
    this.processing = true;
    form.put(route('manager.settings.update'), {
        onFinish: () => {
            this.processing = false;
        }
    });
}
</script>

