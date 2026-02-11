<template>
    <ManagerLayout title="Добавить клиента провайдера">
        <div class="max-w-2xl">
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Создать нового клиента провайдера</h3>

                <form @submit.prevent="storeClient">
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

                        <!-- Адрес -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Адрес
                            </label>
                            <textarea
                                v-model="form.address"
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

<script >
import { reactive } from 'vue';
import { router, Link, useForm } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

export default {
    layout: ManagerLayout,
    components: {ManagerLayout, Link },
    data(){
        return {
            form : useForm({
                type:'',
                name:'',
                email:'',
                phone:'',
                address:'',
                inn:'',
                kpp:'',
                status:'',
                notes:'',
                contact_person:''

            }),
            processing:false
        };
    },
    methods: {

        storeClient(){

            this.processing = true;
            this.form.post(route('manager.provider-clients.store'),{
                onSuccess: (res) =>{
                    if (res.status === 200){
                        alert("Успешно добавлен")
                    }
                },
                onError: (error) =>{
                    alert(error.message)
                }

            });
        }
    }
}

</script>

