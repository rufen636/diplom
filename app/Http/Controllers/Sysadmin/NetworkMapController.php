<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Models\NetworkMap;
use App\Services\Sysadmin\CoverageCheckService;
use Illuminate\Http\Request;

class NetworkMapController extends Controller
{
    protected $coverageCheckService;

    public function __construct(CoverageCheckService $coverageCheckService)
    {
        $this->coverageCheckService = $coverageCheckService;
    }

    public function index()
    {
        $nodes = NetworkMap::all();

        // Добавляем статистику для каждого узла (без привязки к оборудованию)
        $nodes->each(function ($node) {
            $node->equipment_count = 0;
            $node->active_connections = 0;
            $node->load = $node->capacity ? round(($node->current_load / $node->capacity) * 100) : 0;
        });

        return inertia('Sysadmin/NetworkMap/Index', [
            'nodes' => $nodes
        ]);
    }

    public function checkCoverageByAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string'
        ]);

        $result = $this->coverageCheckService->checkByAddress($request->address);

        return response()->json($result);
    }

    public function getNodeDetails(NetworkMap $node)
    {
        return response()->json($node);
    }
}
