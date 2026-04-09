<template>
    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b px-6 py-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    {{ isEditing ? 'Редактировать шаблон' : 'Создать шаблон договора' }}
                </h3>
            </div>

            <form @submit.prevent="saveTemplate" class="p-6">
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
                </div>

                <!-- Редактор разделов -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium text-gray-800">Содержание договора</h4>
                        <button type="button" @click="addSection" class="btn-secondary text-sm">
                            + Добавить раздел
                        </button>
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
                                            <button type="button" @click="removeItem(sIndex, iIndex)" class="text-red-500 hover:text-red-700 text-sm">
                                                ✕
                                            </button>
                                        </div>
                                    </div>

                                    <textarea
                                        v-model="item.content"
                                        rows="3"
                                        class="input-field w-full"
                                        :placeholder="'Введите содержание ' + (item.title || 'пункта')"
                                    ></textarea>
                                </div>

                                <button type="button" @click="addItem(sIndex)" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    + Добавить пункт
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Дополнительные настройки -->
                <div class="border-t pt-6 mt-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Дополнительные настройки</h4>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Стандартный шаблон
                            </label>
                            <input v-model="form.is_default" type="checkbox" class="rounded border-gray-300" />
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
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Заметки
                        </label>
                        <textarea v-model="form.notes" rows="2" class="input-field" placeholder="Внутренние заметки..."></textarea>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Нарисуйте подпись
                    </label>
                    <SignaturePad
                        v-model="form.signature_image"
                        :width="500"
                        :height="200"
                    />
                    <p class="text-xs text-gray-500 mt-1">
                        Нарисуйте подпись с помощью мыши или касанием (на сенсорных экранах)
                    </p>
                </div>
                <!-- Кнопки -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                    <Link :href="route('manager.sample-contracts.index')" class="btn-secondary">
                        Отмена
                    </Link>
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        {{ form.processing ? 'Сохранение...' : (isEditing ? 'Обновить' : 'Создать') }}
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
    components: { Link,SignaturePad },
    props: {
        template: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            form: useForm({
                template_code: this.template?.template_code || '',
                name: this.template?.name || '',
                description: this.template?.description || '',
                contract_type: this.template?.contract_type || 'individual',
                status: this.template?.status || 'draft',
                version: this.template?.version || '1.0',
                is_default: this.template?.is_default || false,
                sections: this.template?.sections || this.getDefaultSections(),
                metadata: this.template?.metadata || {},
                notes: this.template?.notes || '',
                signature_image: null,
            }),
            isEditing: !!this.template
        };
    },
    computed: {
        sections: {
            get() { return this.form.sections; },
            set(val) { this.form.sections = val; }
        }
    },
    methods: {
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

        generateId() {
            return Date.now() + '-' + Math.random().toString(36).substr(2, 9);
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

        saveTemplate() {
            this.form.post(this.isEditing
                ? route('manager.sample-contracts.update', this.template.id)
                : route('manager.sample-contracts.store')
            );
        }
    }
}
</script>
