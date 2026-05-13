<?php

namespace Tests\Unit;

use App\Http\Responses\ApiResponse;
use PHPUnit\Framework\TestCase;

class ApiResponsePrepareModuleTest extends TestCase
{
    public function test_prepare_module_strips_api_v1_prefix_and_digits(): void
    {
        $r = new ApiResponse([]);
        $this->assertSame('tariffs', $r->prepareModule('/api/v1/tariffs/42'));
    }

    public function test_prepare_module_replaces_slashes_with_underscores(): void
    {
        $r = new ApiResponse([]);
        $this->assertSame('a_b_c', $r->prepareModule('/api/v1/a/b/c'));
    }

    public function test_prepare_module_collapses_double_underscores(): void
    {
        $r = new ApiResponse([]);
        $this->assertStringNotContainsString('__', $r->prepareModule('/api/v1/foo//bar'));
    }

    public function test_prepare_module_replaces_hyphens_with_underscores(): void
    {
        $r = new ApiResponse([]);
        $this->assertSame('provider_clients', $r->prepareModule('/api/v1/provider-clients'));
    }

    public function test_prepare_module_trims_trailing_underscore_from_removed_digits(): void
    {
        $r = new ApiResponse([]);
        $out = $r->prepareModule('/api/v1/items/99');
        $this->assertStringEndsNotWith('_', $out);
    }
}
