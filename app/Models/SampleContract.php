<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SampleContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'template_code',
        'name',
        'description',
        'contract_type',
        'status',
        'version',
        'is_default',
        'sections',
        'metadata',
        'notes',
        'detail_id',
    ];

    protected $casts = [
        'sections' => 'array',
        'metadata' => 'array',
        'is_default' => 'boolean',
    ];

    /**
     * Получить разделы с дефолтной структурой если пусто
     */
    public function getSectionsAttribute($value)
    {
        $sections = json_decode($value, true) ?? [];

        if (empty($sections)) {
            return $this->getDefaultSections();
        }

        return $sections;
    }

    /**
     * Структура по умолчанию для нового шаблона
     */
    protected function getDefaultSections(): array
    {
        return [
            [
                'id' => uniqid('sec_'),
                'title' => 'ПРЕАМБУЛА',
                'order' => 1,
                'items' => [
                    [
                        'id' => uniqid('item_'),
                        'number' => null,
                        'title' => null,
                        'content' => '',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => uniqid('sec_'),
                'title' => '1. ПРЕДМЕТ ДОГОВОРА',
                'order' => 2,
                'items' => [
                    [
                        'id' => uniqid('item_'),
                        'number' => '1.1.',
                        'title' => null,
                        'content' => '',
                        'order' => 1,
                        'type' => 'clause',
                        'children' => []
                    ]
                ]
            ]
        ];
    }

    /**
     * Генерация договора с подстановкой данных
     */
    public function generateContract(array $clientData, array $tariffData): string
    {
        $html = '<div class="contract">';

        foreach ($this->sections as $section) {
            $html .= $this->renderSection($section, $clientData, $tariffData);
        }

        $html .= '</div>';

        return $html;
    }

    protected function renderSection(array $section, array $clientData, array $tariffData): string
    {
        $html = '<div class="contract-section mb-6">';

        if (!empty($section['title'])) {
            $html .= "<h3 class='text-lg font-bold mb-3'>{$section['title']}</h3>";
        }

        foreach ($section['items'] as $item) {
            $html .= $this->renderItem($item, $clientData, $tariffData, 0);
        }

        $html .= '</div>';

        return $html;
    }

    protected function renderItem(array $item, array $clientData, array $tariffData, int $level): string
    {
        $content = $this->replaceVariables($item['content'] ?? '', $clientData, $tariffData);
        $marginLeft = $level * 20;

        $html = "<div style='margin-left: {$marginLeft}px; margin-bottom: 8px;'>";

        switch ($item['type'] ?? 'text') {
            case 'clause':
            case 'subclause':
                $number = $item['number'] ?? '';
                $html .= "<p><strong>{$number}</strong> {$content}</p>";
                break;
            case 'list':
                $html .= "<p><strong> " . $item['title'] ?? '' . "</strong></p>";
                $html .= "<ul>" . $this->renderList($content) . "</ul>";
                break;
            case 'signature':
                $html .= "<div class='flex justify-between mt-8'><div><strong>".$item['title'] ?? "Подпись" ."</strong> _________________</div></div>";
                break;
            default:
                $html .= "<p>{$content}</p>";
        }

        // Рекурсивный рендеринг подпунктов
        if (!empty($item['children'])) {
            foreach ($item['children'] as $child) {
                $html .= $this->renderItem($child, $clientData, $tariffData, $level + 1);
            }
        }

        $html .= '</div>';

        return $html;
    }

    protected function replaceVariables(string $content, array $clientData, array $tariffData): string
    {
        $replacements = [
            '{{client.name}}' => $clientData['name'] ?? '',
            '{{client.address}}' => $clientData['address'] ?? '',
            '{{client.phone}}' => $clientData['phone'] ?? '',
            '{{client.email}}' => $clientData['email'] ?? '',
            '{{client.passport}}' => $clientData['passport'] ?? '',
            '{{client.inn}}' => $clientData['inn'] ?? '',
            '{{tariff.name}}' => $tariffData['name'] ?? '',
            '{{tariff.speed}}' => $tariffData['speed'] ?? '',
            '{{tariff.price}}' => $tariffData['price'] ?? '',
            '{{tariff.description}}' => $tariffData['description'] ?? '',
            '{{current_date}}' => now()->format('d.m.Y'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    protected function renderList(string $content): string
    {
        $items = explode("\n", $content);
        $html = '';
        foreach ($items as $item) {
            if (trim($item)) {
                $html .= "<li>{$item}</li>";
            }
        }
        return $html;
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
