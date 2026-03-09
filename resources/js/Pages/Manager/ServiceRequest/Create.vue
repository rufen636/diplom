<template>
    <div class="max-w-2xl">
        <div class="card">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Создать новую заявку</h3>

            <form @submit.prevent="storeClient">
                <div class="space-y-4">
                    <!-- Название заявки -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Название заявки <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="input-field"
                            placeholder="Заявка 1"
                            required
                        />
                    </div>

                    <!-- Описание заявки -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Описание заявки
                        </label>
                        <textarea
                            v-model="form.description"
                            class="input-field"
                            placeholder="Описание заявки"
                            required
                        ></textarea>
                    </div>

                    <!-- Тип клиента -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Выберите тип клиента <span class="text-red-500">*</span>
                        </label>
                        <select class="input-field" v-model="form.client_type">
                            <option disabled value="">Не выбрано</option>
                            <option value="person">Физ. лицо</option>
                            <option value="company">Юр. лицо</option>
                        </select>
                    </div>

                    <!-- Для юридического лица -->
                    <div v-if="form.client_type === 'company'">
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите шаблон договора <span class="text-red-500">*</span>
                            </label>
                            <select class="input-field" v-model="form.sample_contract_id">
                                <option disabled value="">Не выбрано</option>
                                <option
                                    v-for="sample_contract in sample_contracts_company"
                                    :key="sample_contract.id"
                                    :value="sample_contract.id"
                                >
                                    {{ sample_contract.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите клиента <span class="text-red-500">*</span>
                            </label>
                            <select class="input-field mb-2" v-model="form.client_id">
                                <option disabled value="">Не выбрано</option>
                                <option
                                    v-for="provider_client in provider_clients_company"
                                    :key="provider_client.id"
                                    :value="provider_client.id"
                                >
                                    {{ provider_client.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Для физического лица -->
                    <div v-if="form.client_type === 'person'">
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите шаблон договора <span class="text-red-500">*</span>
                            </label>
                            <select class="input-field" v-model="form.sample_contract_id">
                                <option disabled value="">Не выбрано</option>
                                <option
                                    v-for="sample_contract in sample_contracts_person"
                                    :key="sample_contract.id"
                                    :value="sample_contract.id"
                                >
                                    {{ sample_contract.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите клиента <span class="text-red-500">*</span>
                            </label>
                            <select class="input-field" v-model="form.client_id">
                                <option disabled value="">Не выбрано</option>
                                <option
                                    v-for="provider_client in provider_clients_person"
                                    :key="provider_client.id"
                                    :value="provider_client.id"
                                >
                                    {{ provider_client.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Выбор услуги -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Выберите услугу <span class="text-red-500">*</span>
                        </label>
                        <select class="input-field" v-model="form.service_id">
                            <option disabled value="">Не выбрано</option>
                            <option
                                v-for="service in services"
                                :key="service.id"
                                :value="service.id"
                            >
                                {{ service.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Статус заявки -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Выберите статус заявки <span class="text-red-500">*</span>
                        </label>
                        <select class="input-field" v-model="form.status">
                            <option disabled value="">Не выбрано</option>
                            <option value="created">Создана</option>
                            <option value="archived">Архив</option>
                            <option value="accepted">Принята</option>
                            <option value="on_inspection">На проверке</option>
                        </select>
                    </div>

                    <!-- Адрес установки -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Адрес установки
                        </label>
                        <input
                            v-model="form.installation_address"
                            type="text"
                            class="input-field"
                            placeholder="Адрес установки"
                        />
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <Link :href="route('manager.service-requests.index')" class="btn-secondary">
                        Отмена
                    </Link>
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        {{ form.processing ? 'Создание...' : 'Создать заявку' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';

export default {
    layout: ManagerLayout,

    props: {
        sample_contracts_company: Array,
        sample_contracts_person: Array,
        provider_clients_person: Array,
        provider_clients_company: Array,
        services: Array
    },

    components: { Link, ManagerLayout },

    data() {
        return {
            form: this.$inertia.form({
                title: '',
                description: '',
                client_type: '',  // Изменено с 'type' на 'client_type' и добавлено значение по умолчанию
                service_id: '',
                client_id: '',
                sample_contract_id: '',
                installation_address: '',
                status: 'created'       // Добавлено значение по умолчанию
            }),
            isAddressSame: false
        };
    },

    methods: {
        storeClient() {
            console.log('Отправляемые данные:', this.form.data()); // Для отладки

            this.form.post(route('manager.service-requests.store'), {
                onSuccess: (page) => {
                    alert("Успешно добавлен");
                    this.form.reset();
                },
                onError: (errors) => {
                    console.error('Ошибки:', errors);
                    alert('Ошибка при создании заявки: ' + JSON.stringify(errors));
                }
            });
        }
    }
}
</script>
