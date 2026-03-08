<?php

namespace App\Services\Manager\Provider;

use App\DTO\Manager\ProviderDetailDto;
use App\Http\Responses\ApiErrorResponse;
use App\Models\ProviderDetail;

class ProviderDetailService
{

    public function updateOrCreate(ProviderDetailDto $dto)
    {
        try {
            $sample_contract = ProviderDetail::updateOrCreate(
                ['id' => $dto->id]
                , [
                'full_name' => $dto->full_name,
                'legal_address' => $dto->legal_address,
                'actual_address' => $dto->actual_address,
                'phone' => $dto->phone,
                'email' => $dto->email,
                'bank_details' => $dto->bank_details,
                'website' => $dto->website,
            ]);
            return $sample_contract;
        }catch (\Exception $exception){
            \Log::error($exception->getMessage());
            return new ApiErrorResponse([],request(),ApiErrorResponse::DEFAULT_ERROR,$exception->getMessage());
        }

    }
}
