<template>
    <SysadminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">Карта покрытия сети</h1>
                <button
                    @click="openAddModal"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Добавить точку покрытия
                </button>
                <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
                    <!-- Карта -->
                    <div  style="z-index:10;height: 600px; width: 100%; position: relative;">
                        <!-- Индикатор режима добавления -->
                        <div v-if="isAddingMode" class="absolute top-4 right-4 z-10 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg">
                            Режим добавления точки. Нажмите на карту для выбора местоположения
                            <button @click="cancelAddMode" class="ml-2 text-white hover:text-gray-200">✕</button>
                        </div>

                        <LMap
                            ref="map"
                            :zoom="zoom"
                            :center="center"
                            :use-global-leaflet="false"
                            @ready="onMapReady"
                            @click="onMapClick"
                        >
                            <LTileLayer
                                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                attribution="&copy; OpenStreetMap contributors"
                            />

                            <!-- Отображение узлов сети -->
                            <LMarker
                                v-for="node in networkNodes"
                                :key="node.id"
                                :lat-lng="[node.latitude, node.longitude]"
                                @click="selectNode(node)"
                            >
                                <LPopup>
                                    <div class="p-2 min-w-[200px]">
                                        <h3 class="font-bold text-lg">{{ node.name }}</h3>
                                        <p class="text-sm mt-1">Статус:
                                            <span :class="node.is_available ? 'text-green-600' : 'text-red-600'">
                                                {{ node.is_available ? 'Доступен' : 'Недоступен' }}
                                            </span>
                                        </p>
                                        <p class="text-sm">Радиус покрытия: {{ node.coverage_radius }} км</p>
                                        <div class="flex space-x-2 mt-3">
                                            <button
                                                @click.stop="editNode(node)"
                                                class="px-3 py-1 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600"
                                            >
                                                Редактировать
                                            </button>
                                            <button
                                                @click.stop="showNodeDetails(node)"
                                                class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600"
                                            >
                                                Подробнее
                                            </button>
                                        </div>
                                    </div>
                                </LPopup>
                            </LMarker>

                            <!-- Зоны покрытия (круги) -->
                            <LCircle
                                v-for="zone in coverageZones"
                                :key="zone.id"
                                :lat-lng="[zone.latitude, zone.longitude]"
                                :radius="zone.radius * 1000"
                                :color="zone.is_available ? '#10B981' : '#EF4444'"
                                :fill-color="zone.is_available ? '#10B981' : '#EF4444'"
                                :fill-opacity="0.2"
                            />

                            <!-- Предпросмотр новой точки -->
                            <LMarker
                                v-if="tempPoint"
                                :lat-lng="tempPoint"
                                :icon="greenIcon"
                            >
                                <LPopup>
                                    <div class="p-2">
                                        <p class="text-sm font-medium">Новая точка покрытия</p>
                                        <p class="text-xs text-gray-600">Координаты: {{ tempPoint[0].toFixed(6) }}, {{ tempPoint[1].toFixed(6) }}</p>
                                        <button
                                            @click="confirmAddPoint"
                                            class="mt-2 px-3 py-1 bg-green-600 text-white rounded-md text-sm w-full"
                                        >
                                            Добавить точку
                                        </button>
                                        <button
                                            @click="tempPoint = null"
                                            class="mt-1 px-3 py-1 bg-gray-600 text-white rounded-md text-sm w-full"
                                        >
                                            Отмена
                                        </button>
                                    </div>
                                </LPopup>
                            </LMarker>
                        </LMap>
                    </div>

                    <!-- Панель информации -->
                    <div class="p-4 border-t">
                        <div v-if="selectedNode" class="mb-4">
                            <h3 class="text-lg font-medium">Выбранный узел: {{ selectedNode.name }}</h3>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <ul class="mt-1 space-y-1">
                                        <li v-for="equipment in (selectedNode.equipment || [])" :key="equipment.id" class="text-sm">
                                            {{ equipment.name }} ({{ equipment.mac_address || '—' }})
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Статистика:</p>
                                    <p class="text-sm">Активных подключений: {{ selectedNode.active_connections }}</p>
                                    <p class="text-sm">Загрузка: {{ selectedNode.load }}%</p>
                                </div>
                            </div>
                        </div>

                        <!-- Поиск по адресу -->
                        <div class="flex space-x-4">
                            <input
                                type="text"
                                v-model="searchAddress"
                                placeholder="Введите адрес для проверки..."
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                            <button
                                @click="searchByAddress"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                            >
                                Проверить
                            </button>
                        </div>

                        <!-- Результат поиска -->
                        <div v-if="searchResult" class="mt-4 p-3 bg-gray-50 rounded-md">
                            <p class="text-sm">
                                <span class="font-medium">Результат:</span>
                                <span :class="searchResult.available ? 'text-green-600' : 'text-red-600'">
                                    {{ searchResult.available ? 'Доступно' : 'Недоступно' }}
                                </span>
                            </p>
                            <p v-if="searchResult.nearest_node" class="text-sm mt-1">
                                Ближайший узел: {{ searchResult.nearest_node.name }}
                                ({{ (searchResult.distance_km || 0).toFixed(2) }} км)
                            </p>
                            <p v-if="searchResult.error" class="text-sm mt-1 text-red-600">{{ searchResult.message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SysadminLayout>
    <Transition name="modal">
        <div v-if="showModal" class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="saveNode">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                {{ editingNode ? 'Редактировать' : 'Добавить' }} точку покрытия
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Название точки <span class="text-red-500">*</span></label>
                                    <input
                                        type="text"
                                        v-model="nodeForm.name"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Например: Центральный узел"
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Широта <span class="text-red-500">*</span></label>
                                        <input
                                            type="number"
                                            step="any"
                                            v-model="nodeForm.latitude"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Долгота <span class="text-red-500">*</span></label>
                                        <input
                                            type="number"
                                            step="any"
                                            v-model="nodeForm.longitude"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Радиус покрытия (км) <span class="text-red-500">*</span></label>
                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0.1"
                                        v-model="nodeForm.coverage_radius"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Адрес</label>
                                    <input
                                        type="text"
                                        v-model="nodeForm.address"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Физический адрес точки"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Техническая информация</label>
                                    <textarea
                                        v-model="nodeForm.technical_info"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Модель оборудования, провайдер, и т.д."
                                    ></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Максимальная емкость (абонентов)</label>
                                    <input
                                        type="number"
                                        min="1"
                                        v-model="nodeForm.capacity"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="nodeForm.is_available"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    />
                                    <label class="ml-2 block text-sm text-gray-900">Точка доступна</label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                {{ editingNode ? 'Сохранить' : 'Добавить' }}
                            </button>
                            <button
                                type="button"
                                @click="showModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Отмена
                            </button>
                            <button
                                v-if="editingNode"
                                type="button"
                                @click="deleteNode"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Удалить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue'
import { LMap, LTileLayer, LMarker, LPopup, LCircle } from '@vue-leaflet/vue-leaflet'
import 'leaflet/dist/leaflet.css'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'
import { router } from '@inertiajs/vue3'
import L from 'leaflet'
import axios from 'axios'

// Иконки Leaflet
delete L.Icon.Default.prototype._getIconUrl
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
})

// Зеленая иконка для предпросмотра
const greenIcon = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
})

const props = defineProps({
    nodes: {
        type: Array,
        default: () => []
    }
})

// Состояние
const map = ref(null)
const zoom = ref(10)
const center = ref([55.7558, 37.6176])
const networkNodes = ref([])
const coverageZones = ref([])
const selectedNode = ref(null)
const searchAddress = ref('')
const searchResult = ref(null)
const showModal = ref(false)
const editingNode = ref(null)
const isAddingMode = ref(false)
const tempPoint = ref(null)
const loading = ref(false)

// Форма
const nodeForm = reactive({
    name: '',
    latitude: '',
    longitude: '',
    coverage_radius: 5,
    address: '',
    technical_info: '',
    capacity: null,
    is_available: true
})

// Загрузка данных
const loadNodes = async () => {
    try {
        loading.value = true
        const response = await axios.get(route('sysadmin.coverage-points.index'))
        networkNodes.value = response.data
        updateCoverageZones()
    } catch (error) {
        console.error('Ошибка загрузки точек:', error)
        alert('Ошибка при загрузке точек покрытия')
    } finally {
        loading.value = false
    }
}

// Инициализация
onMounted(() => {
    if (props.nodes && props.nodes.length > 0) {
        networkNodes.value = props.nodes
        updateCoverageZones()
    } else {
        loadNodes()
    }
})

// Обновление зон покрытия
const updateCoverageZones = () => {
    coverageZones.value = networkNodes.value.map(node => ({
        id: node.id,
        latitude: node.latitude,
        longitude: node.longitude,
        radius: node.coverage_radius || 5,
        is_available: node.is_available
    }))
}

const onMapReady = () => {
    if (networkNodes.value.length > 0) {
        const bounds = L.latLngBounds(networkNodes.value.map(n => [n.latitude, n.longitude]))
        map.value.leafletObject.fitBounds(bounds)
    }
}

const onMapClick = (event) => {
    console.log('Клик по карте:', event.latlng)
    if (isAddingMode.value) {
        tempPoint.value = [event.latlng.lat, event.latlng.lng]
    }
}

const openAddModal = () => {
    isAddingMode.value = true
    resetForm()
}

const cancelAddMode = () => {
    isAddingMode.value = false
    tempPoint.value = null
}

const confirmAddPoint = () => {
    if (tempPoint.value) {
        nodeForm.latitude = tempPoint.value[0]
        nodeForm.longitude = tempPoint.value[1]
        showModal.value = true
        isAddingMode.value = false
        tempPoint.value = null
        editingNode.value = null
    }
}

const selectNode = (node) => {
    selectedNode.value = node
}

const editNode = (node) => {
    console.log('Редактирование узла:', node)
    editingNode.value = node
    Object.assign(nodeForm, {
        name: node.name || '',
        latitude: node.latitude,
        longitude: node.longitude,
        coverage_radius: node.coverage_radius || 5,
        address: node.address || '',
        technical_info: node.technical_info || '',
        capacity: node.capacity || null,
        is_available: node.is_available
    })
    showModal.value = true
}

const saveNode = async () => {
    try {
        loading.value = true
        const url = editingNode.value
            ? route('sysadmin.coverage-points.update', editingNode.value.id)
            : route('sysadmin.coverage-points.store')

        const method = editingNode.value ? 'put' : 'post'

        const response = await axios[method](url, nodeForm)

        if (response.data.success) {
            // Обновляем список узлов
            await loadNodes()

            // Закрываем модальное окно
            showModal.value = false
            resetForm()

            alert(response.data.message || 'Операция выполнена успешно')
        } else {
            alert('Ошибка: ' + (response.data.message || 'Неизвестная ошибка'))
        }
    } catch (error) {
        console.error('Ошибка сохранения:', error)
        if (error.response?.data?.errors) {
            // Ошибки валидации
            const messages = Object.values(error.response.data.errors).flat().join('\n')
            alert('Ошибка валидации:\n' + messages)
        } else {
            alert('Ошибка при сохранении: ' + (error.response?.data?.message || error.message))
        }
    } finally {
        loading.value = false
    }
}

const deleteNode = async () => {
    if (!confirm('Вы уверены, что хотите удалить эту точку покрытия?')) return

    try {
        loading.value = true
        const response = await axios.delete(route('sysadmin.coverage-points.destroy', editingNode.value.id))

        if (response.data.success) {
            await loadNodes()
            showModal.value = false
            resetForm()
            alert(response.data.message || 'Точка успешно удалена')
        }
    } catch (error) {
        console.error('Ошибка удаления:', error)
        alert('Ошибка при удалении: ' + (error.response?.data?.message || error.message))
    } finally {
        loading.value = false
    }
}

const resetForm = () => {
    editingNode.value = null
    Object.assign(nodeForm, {
        name: '',
        latitude: '',
        longitude: '',
        coverage_radius: 5,
        address: '',
        technical_info: '',
        capacity: null,
        is_available: true
    })
}

const showNodeDetails = (node) => {
    router.get(route('sysadmin.equipment.index'), { node: node.id })
}

const searchByAddress = async () => {
    if (!searchAddress.value) return

    try {
        loading.value = true
        const response = await axios.post(route('sysadmin.check-coverage-by-address'), {
            address: searchAddress.value
        })

        searchResult.value = response.data

        if (response.data.nearest_node && map.value?.leafletObject) {
            map.value.leafletObject.setView(
                [response.data.nearest_node.latitude, response.data.nearest_node.longitude],
                13
            )
        }
    } catch (error) {
        console.error('Ошибка проверки адреса:', error)
        alert('Ошибка при проверке адреса')
    } finally {
        loading.value = false
    }
}
</script>
<style>
.leaflet-control-attribution{
    display: none !important;
}
</style>
<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .sm\:align-middle,
.modal-leave-active .sm\:align-middle {
    transition: transform 0.3s ease;
}

.modal-enter-from .sm\:align-middle,
.modal-leave-to .sm\:align-middle {
    transform: scale(0.9);
}

/* Стили для popup */
:deep(.leaflet-popup-content) {
    margin: 0;
    min-width: 200px;
}

:deep(.leaflet-popup-content-wrapper) {
    padding: 0;
    border-radius: 8px;
    overflow: hidden;
}
.leaflet-control-attribution leaflet-control{
    display: none !important;
}
.leaflet-control{
    opacity: 0;
}
</style>
