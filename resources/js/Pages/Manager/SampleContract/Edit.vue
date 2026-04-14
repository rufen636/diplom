<template>
    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b px-6 py-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    Редактировать шаблон договора
                </h3>
            </div>

            <form @submit.prevent="updateTemplate" class="p-6">
                <!-- Основная информация -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Код шаблона *
                        </label>
                        <input v-model="form.template_code" type="text" class="input-field" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Название шаблона *
                        </label>
                        <input v-model="form.name" type="text" class="input-field" required />
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Тип шаблона *
                        </label>
                        <select v-model="form.contract_type" class="input-field" required>
                            <option value="individual">Физическое лицо</option>
                            <option value="company">Юридическое лицо</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Версия
                        </label>
                        <input v-model="form.version" type="text" class="input-field" placeholder="1.0" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Статус
                        </label>
                        <select v-model="form.status" class="input-field">
                            <option value="draft">Черновик</option>
                            <option value="active">Активный</option>
                            <option value="archived">Архивный</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="block text-sm font-medium text-gray-700">
                            Стандартный шаблон
                        </label>
                        <input v-model="form.is_default" type="checkbox" class="rounded border-gray-300" />
                    </div>
                </div>

                <!-- Редактор разделов -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium text-gray-800">Содержание договора</h4>
                        <button type="button" @click="addSection" class="btn-secondary text-sm">
                            + Добавить раздел
                        </button>
                    </div>
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="text-sm font-medium text-gray-700 mb-2">Доступные переменные (нажмите для вставки):</div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="insertVariableToActiveField('{{client_name}}')" class="variable-btn">
                                👤 Имя клиента
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{client_address}}')" class="variable-btn">
                                📍 Адрес клиента
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{client_phone}}')" class="variable-btn">
                                📞 Телефон клиента
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{client_email}}')" class="variable-btn">
                                ✉️ Email клиента
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{client_inn}}')" class="variable-btn">
                                🆔 ИНН клиента
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{client_passport}}')" class="variable-btn">
                                🪪 Паспортные данные
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{tariff_name}}')" class="variable-btn">
                                📡 Название тарифа
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{tariff_speed}}')" class="variable-btn">
                                ⚡ Скорость тарифа
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{tariff_price}}')" class="variable-btn">
                                💰 Цена тарифа
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{contract_number}}')" class="variable-btn">
                                📄 Номер договора
                            </button>
                            <button type="button" @click="insertVariableToActiveField('{{current_date}}')" class="variable-btn">
                                📅 Текущая дата
                            </button>
                            <button type="button" @click="insertVariableToActiveField('[Город]')" class="variable-btn">
                                🏙️ Город
                            </button>
                            <button type="button" @click="insertVariableToActiveField('[Дата]')" class="variable-btn">
                                📆 Дата договора
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            💡 Кликните на поле ввода, затем нажмите на нужную переменную для вставки
                        </div>
                    </div>
                    <!-- Список разделов -->
                    <div class="space-y-6">
                        <div v-for="(section, sIndex) in sections" :key="section.id" class="border rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <input
                                        v-model="section.title"
                                        type="text"
                                        class="input-field text-lg font-medium"
                                        :placeholder="'Раздел ' + (sIndex + 1)"
                                    />
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <button type="button" @click="moveSectionUp(sIndex)" :disabled="sIndex === 0" class="text-gray-500 hover:text-gray-700">
                                        ↑
                                    </button>
                                    <button type="button" @click="moveSectionDown(sIndex)" :disabled="sIndex === sections.length - 1" class="text-gray-500 hover:text-gray-700">
                                        ↓
                                    </button>
                                    <button type="button" @click="removeSection(sIndex)" class="text-red-500 hover:text-red-700">
                                        ✕
                                    </button>
                                </div>
                            </div>

                            <!-- Пункты раздела -->
                            <div class="ml-6 space-y-3">
                                <div class="flex-1">
                                    <input
                                        v-model="section.title"
                                        type="text"
                                        class="input-field text-lg font-medium"
                                        :placeholder="'Раздел ' + (sIndex + 1)"
                                    />
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <button type="button" @click="moveSectionUp(sIndex)" :disabled="sIndex === 0" class="text-gray-500 hover:text-gray-700">↑</button>
                                    <button type="button" @click="moveSectionDown(sIndex)" :disabled="sIndex === sections.length - 1" class="text-gray-500 hover:text-gray-700">↓</button>
                                    <button type="button" @click="removeSection(sIndex)" class="text-red-500 hover:text-red-700">✕</button>
                                </div>
                            </div>

                            <!-- Пункты раздела -->
                            <div class="ml-6 space-y-3">
                                <div v-for="(item, iIndex) in section.items" :key="item.id" class="border-l-2 pl-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <input
                                                v-if="item.type !== 'text' && item.type !== 'signature'"
                                                v-model="item.title"
                                                type="text"
                                                class="input-field text-sm"
                                                :placeholder="'Пункт ' + (iIndex + 1)"
                                            />
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <select v-model="item.type" class="text-sm border rounded px-2 py-1">
                                                <option value="text">Текст</option>
                                                <option value="clause">Пункт</option>
                                                <option value="list">Список</option>
                                                <option value="signature">Подпись</option>
                                            </select>
                                            <button type="button" @click="removeItem(sIndex, iIndex)" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                                        </div>
                                    </div>

                                    <textarea
                                        :ref="el => setTextareaRef(sIndex, iIndex, el)"
                                        v-model="item.content"
                                        rows="3"
                                        class="input-field w-full"
                                        :placeholder="'Введите содержание ' + (item.title || 'пункта')"
                                        @focus="setActiveField(sIndex, iIndex)"
                                    ></textarea>
                                </div>

                                <button type="button" @click="addItem(sIndex)" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    + Добавить пункт
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Блок подписи -->
                <div class="border-t pt-6 mt-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Подпись и печать</h4>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Текст подписи (ФИО, должность)
                        </label>
                        <textarea
                            v-model="form.signatures_block"
                            rows="2"
                            class="input-field"
                            placeholder="Генеральный директор ООО &quot;Интернет-Провайдер&quot; Иванов И.И."
                        ></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Нарисуйте подпись
                        </label>
                        <SignaturePad
                            v-model="form.signature_image"
                            :width="500"
                            :height="200"
                            :initial-image="form.existing_signature"
                        />
                        <p class="text-xs text-gray-500 mt-1">
                            Нарисуйте подпись с помощью мыши или касанием (на сенсорных экранах)
                        </p>
                    </div>

                    <!-- Отображение существующей подписи -->
                    <div v-if="form.existing_signature && !form.signature_image" class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Текущая подпись
                        </label>
                        <img
                            :src="form.existing_signature"
                            alt="Текущая подпись"
                            class="border rounded-lg max-h-24 w-auto"
                        />
                        <button
                            type="button"
                            @click="clearSignature"
                            class="text-sm text-red-600 hover:text-red-800 mt-1"
                        >
                            Удалить текущую подпись
                        </button>
                    </div>
                </div>

                <!-- Заметки -->
                <div class="border-t pt-6 mt-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Дополнительная информация</h4>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Заметки
                        </label>
                        <textarea v-model="form.notes" rows="2" class="input-field" placeholder="Внутренние заметки..."></textarea>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
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
    components: { Link, SignaturePad },
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
                contract_type: this.sampleContract.contract_type || 'individual',
                status: this.sampleContract.status || 'draft',
                version: this.sampleContract.version || '1.0',
                is_default: this.sampleContract.is_default || false,
                sections: this.sampleContract.sections || this.getDefaultSections(),
                notes: this.sampleContract.notes || '',
                signatures_block: this.sampleContract.signatures_block || '',
                signature_image: null,
                existing_signature: this.sampleContract.image_path && this.sampleContract.image_path.length > 0
                    ? this.sampleContract.image_path[0]
                    : null,
                metadata: this.sampleContract.metadata || {}
            }),
            isEditing: true,
            activeSectionIndex: null,
            activeItemIndex: null,
            textareaRefs: {}
        };
    },
    computed: {
        sections: {
            get() { return this.form.sections; },
            set(val) { this.form.sections = val; }
        }
    },
    methods: {
        generateId() {
            return Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        },

        getDefaultSections() {
            return [
                {
                    id: this.generateId(),
                    title: 'ПРЕАМБУЛА',
                    order: 1,
                    items: [
                        {
                            id: this.generateId(),
                            title: null,
                            content: '',
                            order: 1,
                            type: 'text'
                        }
                    ]
                },
                {
                    id: this.generateId(),
                    title: '1. ПРЕДМЕТ ДОГОВОРА',
                    order: 2,
                    items: [
                        {
                            id: this.generateId(),
                            title: '1.1.',
                            content: '',
                            order: 1,
                            type: 'clause'
                        }
                    ]
                }
            ];
        },

        setTextareaRef(sectionIndex, itemIndex, el) {
            if (el) {
                const key = `${sectionIndex}-${itemIndex}`;
                this.textareaRefs[key] = el;
            }
        },

        setActiveField(sectionIndex, itemIndex) {
            this.activeSectionIndex = sectionIndex;
            this.activeItemIndex = itemIndex;
        },

        insertVariableToActiveField(variable) {
            if (this.activeSectionIndex === null || this.activeItemIndex === null) {
                alert('Сначала кликните на текстовое поле, куда хотите вставить переменную');
                return;
            }

            const key = `${this.activeSectionIndex}-${this.activeItemIndex}`;
            const textarea = this.textareaRefs[key];

            if (!textarea) {
                alert('Не удалось найти текстовое поле');
                return;
            }

            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const currentValue = this.sections[this.activeSectionIndex].items[this.activeItemIndex].content;

            // Вставляем переменную в позицию курсора
            const newValue = currentValue.substring(0, start) + variable + currentValue.substring(end);

            // Обновляем данные через v-model
            this.sections[this.activeSectionIndex].items[this.activeItemIndex].content = newValue;

            // Восстанавливаем фокус и позицию курсора после обновления DOM
            this.$nextTick(() => {
                const updatedTextarea = this.textareaRefs[key];
                if (updatedTextarea) {
                    updatedTextarea.focus();
                    const newPosition = start + variable.length;
                    updatedTextarea.setSelectionRange(newPosition, newPosition);
                }
            });
        },

        addSection() {
            const newId = this.generateId();
            this.sections.push({
                id: newId,
                title: `Новый раздел`,
                order: this.sections.length + 1,
                items: []
            });
        },

        removeSection(index) {
            this.sections.splice(index, 1);
            this.updateOrders();
        },

        moveSectionUp(index) {
            if (index > 0) {
                const temp = this.sections[index];
                this.sections[index] = this.sections[index - 1];
                this.sections[index - 1] = temp;
                this.updateOrders();
            }
        },

        moveSectionDown(index) {
            if (index < this.sections.length - 1) {
                const temp = this.sections[index];
                this.sections[index] = this.sections[index + 1];
                this.sections[index + 1] = temp;
                this.updateOrders();
            }
        },

        addItem(sectionIndex) {
            const section = this.sections[sectionIndex];
            const newItemId = this.generateId();
            const newItem = {
                id: newItemId,
                title: `${section.items.length + 1}.`,
                content: '',
                order: section.items.length + 1,
                type: 'clause'
            };
            section.items.push(newItem);
        },

        removeItem(sectionIndex, itemIndex) {
            this.sections[sectionIndex].items.splice(itemIndex, 1);
        },

        updateOrders() {
            this.sections.forEach((section, idx) => {
                section.order = idx + 1;
            });
        },

        clearSignature() {
            this.form.existing_signature = null;
            this.form.signature_image = null;
        },

        updateTemplate() {
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

<style>
.variable-btn {
    @apply px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded hover:bg-gray-300 transition-colors cursor-pointer;
}
.input-field {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4E89A5] focus:border-transparent;
}
.btn-secondary {
    @apply px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors;
}
.btn-primary {
    @apply bg-[#4E89A5] text-white px-4 py-2 rounded-lg hover:bg-[#416081] transition-colors;
}
</style>
