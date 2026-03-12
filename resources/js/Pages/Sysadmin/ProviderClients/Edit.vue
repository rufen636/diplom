<template>
    <ManagerLayout title="Редактировать клиента провайдера">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать клиента провайдера</h3>

                <form @submit.prevent="updateClient">
                    <div class="space-y-4">
                        <!-- Название компании -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите тип клиента <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <select  class="input-field" v-model="form.type">
                            <option disabled>Не выбрано</option>
                            <option value="person" selected>Физ. лицо</option>
                            <option value="company">Юр. лицо</option>
                        </select>
                        <div v-if="form.type === 'company'" >
                            <div  class="mb-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Название компании <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="input-field"
                                    placeholder="ООО 'Пример'"
                                    required
                                />
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
                                    placeholder="Иванов Иван Иванович"
                                    required
                                />
                            </div>
                        </div>
                        <div  v-else-if="form.type === 'person'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Имя <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.name"
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
                        <!-- Контактное лицо -->


                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="input-field"
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
                                required
                            />
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
                            ></textarea>
                        </div>

                        <div v-if="form.type === 'company'" class="company-detail">
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
                            ></textarea>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <Link :href="route('manager.provider-clients.index')" class="btn-secondary">
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

<script >
import { reactive } from 'vue';
import { router, Link, useForm } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

export default {
    name:"Edit",
    props: {
        client:Object
    },
    layout:ManagerLayout,

    data(){
      return{
          form : useForm({
                      id: this.client.id,
                      type: this.client.type,
                      name: this.client.name,
                      contact_person: this.client.contact_person,
                      email: this.client.email,
                      phone: this.client.phone,
                      address: this.client.address,
                      client_details: {
                          full_name:this.client.client_details.full_name,
                          legal_address: this.client.client_details.legal_address,
                          inn: this.client.client_details.inn,
                          kpp: this.client.client_details.kpp,
                          actual_address: this.client.client_details.actual_address,
                          phone: this.client.client_details.phone,
                          email: this.client.client_details.email,
                          bank_details: this.client.client_details.bank_details,
                          doc_type: this.client.client_details.doc_type,
                          identity_number: this.client.client_details.identity_number,
                      },
                      status: this.client.status,
                      notes: this.client.notes
          }),
          processing: false,
          isAddressSame: false
      }
    },
    mounted(){

          let element = document.getElementById('check-address');
          if (this.client.client_details.actual_address === this.client.client_details.legal_address){
              this.isAddressSame = true;
          }

    },
    methods:{
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
        updateClient(){
            this.form.patch(route('manager.provider-clients.update',this.client.id),{
                onSuccess: (res) =>{

                },
                onError: (error) =>{

                }
            })
        }
    },
}

</script>

