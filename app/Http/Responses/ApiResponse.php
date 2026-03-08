<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Class ApiResponse.
 */
class ApiResponse extends JsonResponse
{

    /**
     * @param $module
     *
     * @return array|string|string[]
     */
    public function prepareModule($module)
    {
        $module = preg_replace('/\/api\/v1\//', '', $module);
        $module = preg_replace('/[0-9]/', '', $module);
        $module = preg_replace('/\//', '_', $module);
        $module = preg_replace('/_$/', '', $module);
        $module = str_replace('__', '_', $module);
        return str_replace('-', '_', $module);
    }

}
