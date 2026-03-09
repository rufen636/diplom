<?php

namespace App\Services\Manager\SampleContract;

use App\DTO\Manager\SampleContract\ServiceRequestDto;
use App\Http\Responses\ApiErrorResponse;
use App\Models\SampleContract;
use App\Services\Manager\Image\ImageService;
use Illuminate\Support\Facades\DB;

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

    public function updateOrCreate(ServiceRequestDto $dto)
    {
        try {
            DB::beginTransaction();
            $sample_contract = SampleContract::updateOrCreate(
                ['id' => $dto->id]
                , [
                'template_code' => $dto->template_code,
                'name' => $dto->name,
                'description' => $dto->description,
                'contract_type' => $dto->contract_type,
                'status' => $dto->status,
                'version' => $dto->version,
                'is_default' => $dto->is_default,
                'preamble' => $dto->preamble,
                'subject_of_contract' => $dto->subject_of_contract,
                'rights' => $dto->rights,
                'payment_terms' => $dto->payment_terms,
                'liability' => $dto->liability,
                'force_majeure' => $dto->force_majeure,
                'dispute_resolution' => $dto->dispute_resolution,
                'confidentiality' => $dto->confidentiality,
                'other_conditions' => $dto->other_conditions,
                'signatures_block' => $dto->signatures_block,
                'clauses' => $dto->clauses,
            ]);
            $this->saveImageService->save($sample_contract, $dto->signature_image);
            DB::commit();
            return $sample_contract;
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error($exception->getMessage());
            return new ApiErrorResponse([],request(),ApiErrorResponse::DEFAULT_ERROR,$exception->getMessage());
        }

    }
}
