<template>
    <div class="max-w-2xl">
        <div class="card">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Создать нового заявку</h3>

            <form @submit.prevent="storeClient">
                <div class="space-y-4">
                    <div v-if="form.type === 'company'">
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Название заявки <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="input-field"
                                placeholder="Заявка 1'"
                                @change="sameName()"
                                required
                            />
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Описание заявки <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                v-model="form.description"
                                type="text"
                                class="input-field"
                                placeholder="Заявка 1'"
                                @change="sameName()"
                                required
                            ></textarea>
                        </div>
                        <!-- Название компании -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите шаблон даговора <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <select class="input-field" v-model="form.type">
                            <option disabled>Не выбрано</option>
                            <option value="person" selected>Физ. лицо</option>
                            <option value="company">Юр. лицо</option>
                        </select>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите клиента <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <select class="input-field" v-model="form.type">
                            <option disabled>Не выбрано</option>
                            <option value="person" selected>Физ. лицо</option>
                            <option value="company">Юр. лицо</option>
                        </select>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите услугу <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <select class="input-field" v-model="form.type">
                            <option disabled>Не выбрано</option>
                            <option value="person" selected>Физ. лицо</option>
                            <option value="company">Юр. лицо</option>
                        </select>
                        <!-- Контактное лицо -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите статус заявки <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <select class="input-field" v-model="form.type">
                            <option disabled>Не выбрано</option>
                            <option value="person" selected>Создана</option>
                            <option value="company">Архив</option>
                            <option value="person" selected>Принята</option>
                            <option value="person" selected>На проверке</option>
                        </select>
                    </div>
                    <div v-else-if="form.type === 'person'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Имя <span class="text-red-500">*</span>
                        </label>

                        <input
                            v-model="form.name"
                            @change="sameName()"
                            type="text"
                            class="input-field"
                            placeholder="Иванов Иван Иванович"
                            required
                        />
                        <div hidden>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Контактное лицо <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="input-field"
                                required
                            />

                        </div>
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

                            placeholder="example@company.ru"
                            required
                        />
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
                            placeholder="+7 (999) 123-45-67"
                            required
                        />
                    </div>

                    <div v-if="form.type === 'company'">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Фактический адрес
                            </label>
                            <textarea
                                @change="sameAddress"
                                v-model="form.address"
                                rows="2"
                                class="input-field"
                                placeholder="г. Москва, ул. Примерная, д. 1"
                            ></textarea>
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
                        <div >
                            <label class="mt-2 block text-sm font-medium text-gray-700 mb-2">
                                Юридический адрес
                            </label>
                            <textarea
                                v-model="form.client_details.legal_address"
                                rows="2"
                                class="input-field"
                                placeholder="г. Москва, ул. Примерная, д. 1"
                            ></textarea>
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
                                    placeholder="1234567890"
                                />
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
                                    placeholder="123456789"
                                />
                            </div>
                        </div>
                        <div >
                            <label class="mt-2 block text-sm font-medium text-gray-700 mb-2">
                                Информация о банке
                            </label>
                            <textarea
                                v-model="form.client_details.bank_details"
                                rows="2"
                                class="input-field"
                                placeholder="г. Москва, ул. Примерная, д. 1"
                            ></textarea>
                        </div>
                    </div>
                    <div v-else-if="form.type === 'person'">
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                 Адрес
                            </label>
                            <textarea
                                @change="sameAddress"
                                v-model="form.address"
                                rows="2"
                                class="input-field"
                                placeholder="г. Москва, ул. Примерная, д. 1"
                            ></textarea>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Вид документа
                            </label>
                        <select class="input-field" v-model="form.client_details.doc_type">
                            <option disabled>Не выбрано</option>
                            <option value="passport">Паспорт</option>
                            <option value="resident_card" selected>Вид на жительство</option>
                            <option value="other">Другое</option>
                        </select>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Идентификационный номер
                            </label>
                            <input
                                v-model="form.client_details.identity_number"
                                type="text"
                                maxlength="16"
                                class="input-field"
                                placeholder="123456789"
                            />
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
                            required
                        >
                            <option value="active">Активен</option>
                            <option value="inactive">Неактивен</option>
                            <option value="blocked">Заблокирован</option>
                        </select>
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
                            placeholder="Дополнительная информация о клиенте..."
                        ></textarea>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <Link :href="route('manager.service-requests.index')" class="btn-secondary">
                        Отмена
                    </Link>
                    <button type="submit" class="btn-primary" :disabled="processing">
                        {{ processing ? 'Создание...' : 'Создать клиента' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {reactive} from 'vue';
import {router, Link, useForm} from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';
import forms from "@tailwindcss/forms";
import TextInput from "@/Components/TextInput.vue";

export default {
    layout: ManagerLayout,
    components: {TextInput, ManagerLayout, Link},
    data() {
        return {
            form: useForm({
                type: '',
                name: '',
                email: '',
                phone: '',
                address: '',
                inn: '',
                kpp: '',
                status: '',
                notes: '',
                contact_person: '',
                client_details: {
                    full_name:'',
                    legal_address: '',
                    inn: '',
                    kpp: '',
                    actual_address: '',
                    phone: '',
                    email: '',
                    bank_details: '',
                    doc_type: '',
                    identity_number: '',
                }

            }),
            processing: false,
            isAddressSame: false
        };
    },
    methods: {
        checkAddress() {
            if (this.isAddressSame) {
                this.form.client_details.legal_address = this.form.address;
            } else {
                this.form.client_details.legal_address = '';
            }
        },

        sameAddress() {
            this.form.client_details.actual_address = this.form.address;

            if (this.isAddressSame) {
                this.form.client_details.legal_address = this.form.address;
            }
        },
        sameName(){
          this.form.client_details.full_name = this.form.name;
        },
        storeClient() {

            this.processing = true;
            this.form.post(route('manager.service-requests.store'), {
                onSuccess: (res) => {
                    if (res.status === 200) {
                        alert("Успешно добавлен")
                    }
                },
                onError: (error) => {
                    alert(error.message)
                }

            });
        }
    }
}

</script>

