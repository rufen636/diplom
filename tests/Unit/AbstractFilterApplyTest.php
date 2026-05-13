<?php

namespace Tests\Unit;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Tests\TestCase;

class AbstractFilterApplyTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_apply_calls_matching_key_method(): void
    {
        $builder = Mockery::mock(Builder::class);
        $filter = new class extends AbstractFilter
        {
            /** @var list<string> */
            public array $calls = [];

            protected array $keys = ['status'];

            public function status(Builder $builder, mixed $value): void
            {
                $this->calls[] = (string) $value;
            }
        };

        $filter->apply(['status' => 'active'], $builder);

        $this->assertSame(['active'], $filter->calls);
    }

    public function test_apply_ignores_keys_not_in_filter_definition(): void
    {
        $builder = Mockery::mock(Builder::class);
        $filter = new class extends AbstractFilter
        {
            public int $called = 0;

            protected array $keys = ['only_this'];

            public function onlyThis(Builder $builder, mixed $value): void
            {
                $this->called++;
            }
        };

        $filter->apply(['other' => 1], $builder);

        $this->assertSame(0, $filter->called);
    }
}
