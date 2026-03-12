<?php

namespace App\Http\Resources\Manager\SampleContract;

use App\Services\Manager\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SampleContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


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
            'preamble' => $this->preamble,
            'subject_of_contract' => $this->subject_of_contract,
            'rights' => $this->rights,
            'payment_terms' => $this->payment_terms,
            'liability' => $this->liability,
            'force_majeure' => $this->force_majeure,
            'dispute_resolution' => $this->dispute_resolution,
            'confidentiality' => $this->confidentiality,
            'other_conditions' => $this->other_conditions,
            'signatures_block' => $this->signatures_block,
            'clauses' => $this->clauses,
            'image_path' =>  $imageService->url($this->images->pluck('big_uri')->toArray()),
        ];
    }
}
