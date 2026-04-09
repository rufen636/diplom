<template>
    <div :style="{ marginLeft: (level * 20) + 'px' }" class="mb-3">
        <div class="flex justify-between items-start gap-2 mb-2">
            <div class="flex-1">
                <div class="flex gap-2 mb-1">
                    <span v-if="item.number" class="text-sm font-mono text-gray-500 min-w-[60px]">
                        {{ item.number }}
                    </span>
                    <select v-model="item.type" class="text-sm border rounded px-2 py-1">
                        <option value="text">Текст</option>
                        <option value="clause">Пункт</option>
                        <option value="subclause">Подпункт</option>
                        <option value="list">Список</option>
                        <option value="signature">Подпись</option>
                    </select>
                </div>
                <textarea
                    v-model="item.content"
                    rows="3"
                    class="input-field w-full"
                    :placeholder="'Введите содержание ' + (item.number || 'пункта')"
                ></textarea>
            </div>
            <div class="flex gap-1">
                <button type="button" @click="$emit('add-child')" class="text-green-500 hover:text-green-700 text-sm" title="Добавить подпункт">
                    + Подпункт
                </button>
                <button type="button" @click="$emit('remove-item')" class="text-red-500 hover:text-red-700 text-sm" title="Удалить">
                    ✕
                </button>
            </div>
        </div>

        <!-- Рекурсивный рендеринг подпунктов -->
        <div v-if="item.children && item.children.length" class="mt-2">
            <ContractItemEditor
                v-for="(child, idx) in item.children"
                :key="child.id"
                :item="child"
                :level="level + 1"
                @update-item="(updated) => updateChild(idx, updated)"
                @add-child="addChildToChild(idx)"
                @remove-item="removeChild(idx)"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: 'ContractItemEditor',
    props: {
        item: { type: Object, required: true },
        level: { type: Number, default: 1 }
    },
    emits: ['update-item', 'add-child', 'remove-item'],
    methods: {
        updateChild(index, updatedChild) {
            const newChildren = [...this.item.children];
            newChildren[index] = updatedChild;
            this.$emit('update-item', { ...this.item, children: newChildren });
        },
        addChildToChild(index) {
            const child = this.item.children[index];
            const newChildNumber = child.number + (child.children.length + 1) + '.';
            const newChild = {
                id: Date.now() + '-' + Math.random().toString(36).substr(2, 9),
                number: newChildNumber,
                title: newChildNumber,
                content: '',
                order: child.children.length + 1,
                type: 'subclause',
                children: []
            };
            const newChildren = [...this.item.children];
            newChildren[index].children.push(newChild);
            this.$emit('update-item', { ...this.item, children: newChildren });
        },
        removeChild(index) {
            const newChildren = [...this.item.children];
            newChildren.splice(index, 1);
            this.$emit('update-item', { ...this.item, children: newChildren });
        }
    }
}
</script>
