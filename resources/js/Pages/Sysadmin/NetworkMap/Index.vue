<template>
    <SysadminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">Карта покрытия сети</h1>

                <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
                    <!-- Карта -->
                    <div style="height: 600px; width: 100%;">
                        <LMap
                            ref="map"
                            :zoom="zoom"
                            :center="center"
                            :use-global-leaflet="false"
                            @ready="onMapReady"
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
                                    <div class="p-2">
                                        <h3 class="font-bold">{{ node.name }}</h3>
                                        <p class="text-sm">Статус: {{ node.is_available ? 'Доступен' : 'Недоступен' }}</p>
                                        <p class="text-sm">Оборудование: {{ node.equipment_count }} шт.</p>
                                        <button
                                            @click="showNodeDetails(node)"
                                            class="mt-2 text-indigo-600 hover:text-indigo-900 text-sm"
                                        >
                                            Подробнее
                                        </button>
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
                        </LMap>
                    </div>

                    <!-- Панель информации -->
                    <div class="p-4 border-t">
                        <div v-if="selectedNode" class="mb-4">
                            <h3 class="text-lg font-medium">Выбранный узел: {{ selectedNode.name }}</h3>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Оборудование:</p>
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
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { LMap, LTileLayer, LMarker, LPopup, LCircle } from '@vue-leaflet/vue-leaflet'
import 'leaflet/dist/leaflet.css'
import SysadminLayout from '@/Layouts/Sysadmin/SysadminLayout.vue'
import { router } from '@inertiajs/vue3'

// Исправление для иконок Leaflet (Vite не поддерживает require)
import L from 'leaflet'
import iconUrl from 'leaflet/dist/images/marker-icon.png'
import iconRetinaUrl from 'leaflet/dist/images/marker-icon-2x.png'
import shadowUrl from 'leaflet/dist/images/marker-shadow.png'
delete L.Icon.Default.prototype._getIconUrl
L.Icon.Default.mergeOptions({ iconUrl, iconRetinaUrl, shadowUrl })

const props = defineProps({
    nodes: {
        type: Array,
        required: true
    }
})

const map = ref(null)
const zoom = ref(10)
const center = ref([55.7558, 37.6176]) // Москва по умолчанию
const networkNodes = ref(props.nodes)
const coverageZones = ref([])
const selectedNode = ref(null)
const searchAddress = ref('')
const searchResult = ref(null)

// Подготовка зон покрытия
onMounted(() => {
    coverageZones.value = networkNodes.value.map(node => ({
        id: node.id,
        latitude: node.latitude,
        longitude: node.longitude,
        radius: node.coverage_radius || 5, // радиус в км
        is_available: node.is_available
    }))
})

const onMapReady = () => {
    // Центрируем карту по всем узлам
    if (networkNodes.value.length > 0) {
        const bounds = L.latLngBounds(networkNodes.value.map(n => [n.latitude, n.longitude]))
        map.value.leafletObject.fitBounds(bounds)
    }
}

const selectNode = (node) => {
    selectedNode.value = node
}

const showNodeDetails = (node) => {
    router.get(route('sysadmin.equipment.index'), { node: node.id })
}

const searchByAddress = async () => {
    if (!searchAddress.value) return

    try {
        const response = await axios.post(route('sysadmin.check-coverage-by-address'), {
            address: searchAddress.value
        })

        searchResult.value = response.data

        // Центрируем карту на найденном узле
        if (response.data.nearest_node && map.value?.leafletObject) {
            map.value.leafletObject.setView(
                [response.data.nearest_node.latitude, response.data.nearest_node.longitude],
                13
            )
        }
    } catch (error) {
        console.error('Ошибка проверки адреса:', error)
    }
}
</script>
<style>
.leaflet-control-attribution{
    display: none !important;
}
</style>
