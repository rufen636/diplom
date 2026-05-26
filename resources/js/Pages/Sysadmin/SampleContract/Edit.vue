<template>
    <div class="max-w-2xl">
        <div class="card">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Редактировать шаблон договора</h3>

            <form @submit.prevent="updateSampleContract">
                <div class="space-y-4">
                    <!-- Существующие поля -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Код шаблона <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.template_code"
                            type="text"
                            class="input-field"
                            placeholder=""
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Название шаблона <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="input-field"
                            placeholder=""
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Описание <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.description"
                            type="text"
                            class="input-field"
                            placeholder="Описание шаблона"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Выберите тип шаблона <span class="text-red-500">*</span>
                        </label>
                        <select class="input-field" v-model="form.contract_type" required>
                            <option value="" disabled>Не выбрано</option>
                            <option value="individual">Физ. лицо</option>
                            <option value="company">Юр. лицо</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Выберите статус договора <span class="text-red-500">*</span>
                        </label>
                        <select class="input-field" v-model="form.status" required>
                            <option value="" disabled>Не выбрано</option>
                            <option value="draft">Черновик</option>
                            <option value="active">Активный</option>
                            <option value="archived">В архиве</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Версия договора <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.version"
                            type="text"
                            class="input-field"
                            placeholder="1.0.0"
                            required
                        />
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="block text-sm font-medium text-gray-700">
                            Стандартный шаблон?
                        </label>
                        <input
                            v-model="form.is_default"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Преамбула шаблона
                        </label>
                        <textarea
                            v-model="form.preamble"
                            rows="2"
                            class="input-field"
                            placeholder="Вводная часть"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Объект договора
                        </label>
                        <textarea
                            v-model="form.subject_of_contract"
                            rows="2"
                            class="input-field"
                            placeholder="Объект договора"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Права
                            </label>
                            <textarea
                                v-model="form.rights"
                                rows="2"
                                class="input-field"
                                placeholder="Права и обязанности"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Условия оплаты
                            </label>
                            <textarea
                                v-model="form.payment_terms"
                                rows="2"
                                class="input-field"
                                placeholder="Условия оплаты"
                            ></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Обязанности
                        </label>
                        <textarea
                            v-model="form.liability"
                            rows="2"
                            class="input-field"
                            placeholder="Обязанности"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Конфиденциальность
                        </label>
                        <textarea
                            v-model="form.confidentiality"
                            rows="2"
                            class="input-field"
                            placeholder="Конфиденциальность"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Форс-мажор
                        </label>
                        <textarea
                            v-model="form.force_majeure"
                            rows="2"
                            class="input-field"
                            placeholder="Форс-мажорные обстоятельства"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Порядок разрешения споров
                        </label>
                        <textarea
                            v-model="form.dispute_resolution"
                            rows="2"
                            class="input-field"
                            placeholder="Разрешение споров"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Другие условия
                        </label>
                        <textarea
                            v-model="form.other_conditions"
                            rows="2"
                            class="input-field"
                            placeholder="Другие условия"
                        ></textarea>
                    </div>

                    <!-- Блок подписи -->
                    <div class="border-t pt-4 mt-4">
                        <label class="block text-lg font-medium text-gray-800 mb-4">
                            Блок подписи
                        </label>

                        <!-- Поле для текста подписи -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Текст подписи
                            </label>
                            <textarea
                                v-model="form.signatures_block"
                                rows="3"
                                class="input-field"
                                placeholder="Текст для блока подписи (ФИО, должность и т.д.)"
                            ></textarea>
                        </div>

                        <!-- Компонент для рисования подписи -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Нарисуйте подпись
                            </label>
                            <SignaturePad
                                v-model="form.signature_image"
                                :width="500"
                                :height="200"
                                :initial-image="form.signature_image"
                            />
                            <p class="text-xs text-gray-500 mt-1">
                                Нарисуйте подпись с помощью мыши или касанием (на сенсорных экранах)
                            </p>
                        </div>

                        <!-- Отображение сохраненной подписи -->
                        <div v-if="form.image_path && form.image_path.length > 0" class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Текущая подпись
                            </label>
                            <img
                                :src="form.image_path[0]"
                                alt="Подпись"
                                class="border rounded-lg max-w-full h-auto"
                                style="max-height: 100px;"
                            />
                        </div>
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
                            placeholder="Дополнительная информация..."
                        ></textarea>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <Link :href="route('manager.sample-contracts.index')" class="btn-secondary">
                        Отмена
                    </Link>
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        {{ form.processing ? 'Сохранение...' : 'Сохранить изменения' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link, useForm } from '@inertiajs/vue3';
import ManagerLayout from '@/Layouts/Manager/ManagerLayout.vue';
import SignaturePad from '@/Pages/SignaturePad.vue';

export default {
    layout: ManagerLayout,
    components: {
        Link,
        SignaturePad
    },

    props: {
        sampleContract: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            form: useForm({
                id: this.sampleContract.id,
                template_code: this.sampleContract.template_code || '',
                name: this.sampleContract.name || '',
                description: this.sampleContract.description || '',
                contract_type: this.sampleContract.contract_type || '',
                status: this.sampleContract.status || '',
                version: this.sampleContract.version || '',
                is_default: this.sampleContract.is_default || false,
                preamble: this.sampleContract.preamble || '',
                subject_of_contract: this.sampleContract.subject_of_contract || '',
                rights: this.sampleContract.rights || '',
                payment_terms: this.sampleContract.payment_terms || '',
                liability: this.sampleContract.liability || '',
                force_majeure: this.sampleContract.force_majeure || '',
                dispute_resolution: this.sampleContract.dispute_resolution || '',
                confidentiality: this.sampleContract.confidentiality || '',
                other_conditions: this.sampleContract.other_conditions || '',
                signatures_block: this.sampleContract.signatures_block || '',
                signature_image: null,
                image_path: this.sampleContract.image_path || [],
                clauses: this.sampleContract.clauses || '',
                notes: this.sampleContract.notes || ''
            })
        };
    },

    methods: {
        updateSampleContract() {
            this.form.put(route('manager.sample-contracts.update', this.sampleContract.id), {
                onSuccess: () => {
                    // Обработка успеха
                },
                onError: (errors) => {
                    console.error('Ошибки:', errors);
                }
            });
        }
    }
}
</script>
