<?php

namespace App\Http\Resources\Manager\SampleContract;

use App\Services\Manager\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SampleContractResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageService = App::make(ImageService::class);

        return [
            'id' => $this->id,
            'template_code' => $this->template_code,
            'name' => $this->name,
            'description' => $this->description,
            'contract_type' => $this->contract_type,
            'status' => $this->status,
            'version' => $this->version,
            'is_default' => $this->is_default,
            'sections' => $this->sections,        // ← добавить
            'notes' => $this->notes,              // ← добавить
            'signatures_block' => $this->signatures_block,
            'metadata' => $this->metadata,        // ← добавить
            'image_path' => $imageService->url($this->images->pluck('big_uri')->toArray()),
        ];
    }
}
