<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Internal;

use BytesCommerce\OnOffice\Internal\FakeTimeProvider;
use BytesCommerce\OnOffice\Internal\SystemTimeProvider;
use PHPUnit\Framework\TestCase;

final class TimeProviderTest extends TestCase
{
    public function testSystemTimeProviderReturnsCurrentTime(): void
    {
        $provider = new SystemTimeProvider();
        $before = time();
        $result = $provider->time();
        $after = time();

        $this->assertGreaterThanOrEqual($before, $result);
        $this->assertLessThanOrEqual($after, $result);
    }

    public function testFakeTimeProviderReturnsConfiguredTimestamp(): void
    {
        $timestamp = 1_234_567_890;
        $provider = new FakeTimeProvider($timestamp);

        $this->assertSame($timestamp, $provider->time());
    }

    public function testFakeTimeProviderWithZeroTimestamp(): void
    {
        $provider = new FakeTimeProvider(0);

        $this->assertSame(0, $provider->time());
    }

    public function testFakeTimeProviderWithNegativeTimestamp(): void
    {
        $provider = new FakeTimeProvider(-1);

        $this->assertSame(-1, $provider->time());
    }
}
