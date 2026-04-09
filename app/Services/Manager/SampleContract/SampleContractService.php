<?php

namespace App\Services\Manager\SampleContract;

use App\DTO\Manager\SampleContract\SampleContractDto;
use App\Models\SampleContract;
use App\Services\Manager\Image\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SampleContractService
{
    protected ImageService $saveImageService;

    /**
     * @param ImageService $saveImageService
     */
    public function __construct(ImageService $saveImageService)
    {
        $this->saveImageService = $saveImageService;
    }
    public function updateOrCreate(SampleContractDto $dto): SampleContract
    {
        try {
            DB::beginTransaction();
            $sampleContract = SampleContract::updateOrCreate(
                ['id' => $dto->id],
                [
                    'template_code' => $dto->template_code,
                    'name' => $dto->name,
                    'description' => $dto->description,
                    'contract_type' => $dto->contract_type,
                    'status' => $dto->status,
                    'version' => $dto->version,
                    'is_default' => $dto->is_default,
                    'sections' => $dto->sections,
                    'metadata' => $dto->metadata,
                    'notes' => $dto->notes,
                ]
            );

            // Если это стандартный шаблон, снимаем флаг is_default с других
            if ($dto->is_default) {
                SampleContract::where('id', '!=', $sampleContract->id)
                    ->where('contract_type', $dto->contract_type)
                    ->update(['is_default' => false]);
            }
            $this->saveImageService->save($sampleContract, $dto->signature_image);
            DB::commit();

            return $sampleContract;

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('SampleContract creation error: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
                'dto' => $dto
            ]);
            throw $exception;
        }
    }
}
