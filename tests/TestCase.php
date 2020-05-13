<?php

namespace Tests;

use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('props', function ($key = null) {
            $props = json_decode($this->actual(), JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });

        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));

            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);

            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            return $this;
        });

        TestResponse::macro('assertPropCount', function ($key, $count) {
            $this->assertHasProp($key);

            Assert::assertCount($count, $this->props($key));

            return $this;
        });
    
        TestResponse::macro('assertPropsFragment', function ($data) {
            $actual = $this->actual();

            foreach (Arr::sortRecursive($data) as $key => $value) {
                $expected = $this->jsonSearchStrings($key, $value);
    
                Assert::assertTrue(
                    Str::contains($actual, $expected),
                    'Unable to find props fragment: '.PHP_EOL.PHP_EOL.
                    '['.json_encode([$key => $value]).']'.PHP_EOL.PHP_EOL.
                    'within'.PHP_EOL.PHP_EOL.
                    "[{$actual}]."
                );
            }
        
            return $this;
        });

        TestResponse::macro('actual', function () {
            return json_encode($this->original->getData()['page']['props']);
        });
    }
}
