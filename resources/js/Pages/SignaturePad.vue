<template>
    <div class="signature-pad-container">
        <div class="border border-gray-300 rounded-lg overflow-hidden bg-white">
            <canvas
                ref="canvas"
                :width="width"
                :height="height"
                class="touch-none cursor-crosshair"
                @mousedown="startDrawing"
                @mousemove="draw"
                @mouseup="stopDrawing"
                @mouseleave="stopDrawing"
                @touchstart="startDrawingTouch"
                @touchmove="drawTouch"
                @touchend="stopDrawing"
            ></canvas>
        </div>

        <div class="flex items-center gap-2 mt-2">
            <button
                type="button"
                @click="clearSignature"
                class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors"
            >
                Очистить
            </button>
            <button
                type="button"
                @click="undo"
                class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors"
                :disabled="!canUndo"
            >
                Отменить
            </button>
            <span v-if="hasSignature" class="text-sm text-green-600 ml-2">
                ✓ Подпись добавлена
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        width: {
            type: Number,
            default: 500
        },
        height: {
            type: Number,
            default: 200
        },
        modelValue: {
            type: File,
            default: null
        }
    },

    emits: ['update:modelValue', 'change'],

    data() {
        return {
            isDrawing: false,
            lastX: 0,
            lastY: 0,
            ctx: null,
            history: [],
            historyIndex: -1,
            maxHistorySteps: 20,
            hasSignature: false
        }
    },

    computed: {
        canUndo() {
            return this.historyIndex > 0
        }
    },

    watch: {
        modelValue: {
            handler(newVal) {
                if (newVal && !this.hasSignature) {
                    this.loadSignatureFromFile(newVal)
                }
            },
            immediate: true
        }
    },

    mounted() {
        this.initCanvas()
    },

    methods: {
        initCanvas() {
            const canvas = this.$refs.canvas
            this.ctx = canvas.getContext('2d')

            // Настройки пера
            this.ctx.lineWidth = 2
            this.ctx.lineCap = 'round'
            this.ctx.lineJoin = 'round'
            this.ctx.strokeStyle = '#000'

            // Заполняем белым фоном
            this.ctx.fillStyle = '#fff'
            this.ctx.fillRect(0, 0, this.width, this.height)

            this.saveState()
        },

        async loadSignatureFromFile(file) {
            if (!file) return

            const reader = new FileReader()
            reader.onload = (e) => {
                const img = new Image()
                img.onload = () => {
                    this.ctx.drawImage(img, 0, 0, this.width, this.height)
                    this.hasSignature = true
                    this.saveState()
                }
                img.src = e.target.result
            }
            reader.readAsDataURL(file)
        },

        startDrawing(e) {
            e.preventDefault()
            this.isDrawing = true
            const pos = this.getCoordinates(e)
            this.lastX = pos.x
            this.lastY = pos.y
            this.ctx.beginPath()
            this.ctx.moveTo(this.lastX, this.lastY)
        },

        startDrawingTouch(e) {
            e.preventDefault()
            this.startDrawing(e.touches[0])
        },

        draw(e) {
            if (!this.isDrawing) return
            e.preventDefault()

            const pos = this.getCoordinates(e)

            this.ctx.beginPath()
            this.ctx.moveTo(this.lastX, this.lastY)
            this.ctx.lineTo(pos.x, pos.y)
            this.ctx.stroke()

            this.lastX = pos.x
            this.lastY = pos.y
        },

        drawTouch(e) {
            e.preventDefault()
            this.draw(e.touches[0])
        },

        stopDrawing() {
            if (this.isDrawing) {
                this.isDrawing = false
                this.saveState()
                this.saveSignatureAsFile()
            }
        },

        getCoordinates(e) {
            const canvas = this.$refs.canvas
            const rect = canvas.getBoundingClientRect()
            const scaleX = canvas.width / rect.width
            const scaleY = canvas.height / rect.height

            return {
                x: (e.clientX - rect.left) * scaleX,
                y: (e.clientY - rect.top) * scaleY
            }
        },

        clearSignature() {
            this.ctx.fillStyle = '#fff'
            this.ctx.fillRect(0, 0, this.width, this.height)
            this.hasSignature = false
            this.saveState()
            this.saveSignatureAsFile()
        },

        saveState() {
            // Сохраняем состояние для undo
            const imageData = this.ctx.getImageData(0, 0, this.width, this.height)

            // Обрезаем историю если нужно
            if (this.historyIndex < this.history.length - 1) {
                this.history = this.history.slice(0, this.historyIndex + 1)
            }

            this.history.push(imageData)
            this.historyIndex++

            // Ограничиваем размер истории
            if (this.history.length > this.maxHistorySteps) {
                this.history.shift()
                this.historyIndex--
            }
        },

        undo() {
            if (this.historyIndex > 0) {
                this.historyIndex--
                this.ctx.putImageData(this.history[this.historyIndex], 0, 0)
                this.hasSignature = this.historyIndex > 0
                this.saveSignatureAsFile()
            }
        },

        async saveSignatureAsFile() {
            // Конвертируем canvas в blob
            const canvas = this.$refs.canvas

            // Проверяем, пустая ли подпись
            const context = canvas.getContext('2d')
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height)
            const isEmpty = this.isSignatureEmpty(imageData)

            if (isEmpty) {
                this.hasSignature = false
                this.$emit('update:modelValue', null)
                this.$emit('change', null)
                return
            }

            // Конвертируем canvas в blob
            canvas.toBlob((blob) => {
                // Создаем файл из blob
                const file = new File(
                    [blob],
                    `signature-${Date.now()}.png`,
                    { type: 'image/png' }
                )

                this.hasSignature = true
                this.$emit('update:modelValue', file)
                this.$emit('change', file)
            }, 'image/png')
        },

        isSignatureEmpty(imageData) {
            const data = imageData.data
            // Проверяем, есть ли не-белые пиксели
            for (let i = 0; i < data.length; i += 4) {
                // Проверяем альфа-канал и цвет
                if (data[i + 3] > 0 && (data[i] < 250 || data[i + 1] < 250 || data[i + 2] < 250)) {
                    return false
                }
            }
            return true
        }
    }
}
</script>

<style scoped>
.signature-pad-container {
    user-select: none;
}
</style>
