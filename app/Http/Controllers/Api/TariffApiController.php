<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TariffApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tariffs = Tariff::query()
            ->where('user_id', $request->user()->id)
            ->ordered()
            ->get();

        return response()->json(['data' => $tariffs]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'speed' => 'required|integer|min:1',
            'duration_months' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $validated['user_id'] = $request->user()->id;
        $validated['is_active'] = $validated['is_active'] ?? true;
        $tariff = Tariff::create($validated);

        return response()->json(['data' => $tariff], 201);
    }

    public function update(Request $request, Tariff $tariff): JsonResponse
    {
        abort_if($tariff->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'speed' => 'required|integer|min:1',
            'duration_months' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $tariff->update($validated);

        return response()->json(['data' => $tariff->fresh()]);
    }

    public function destroy(Request $request, Tariff $tariff): JsonResponse
    {
        abort_if($tariff->user_id !== $request->user()->id, 403);
        $tariff->delete();

        return response()->json(null, 204);
    }
}
