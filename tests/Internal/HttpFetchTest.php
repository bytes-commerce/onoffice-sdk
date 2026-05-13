<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Internal;

use BytesCommerce\OnOffice\Internal\HttpFetch;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class HttpFetchTest extends TestCase
{
    public function testConstructorSetsUrlAndPostData(): void
    {
        $httpFetch = new HttpFetch('https://example.com/api', '{"test": "data"}');

        $reflection = new ReflectionClass($httpFetch);
        $urlProperty = $reflection->getProperty('url');
        $urlProperty->setAccessible(true);
        $postDataProperty = $reflection->getProperty('postData');
        $postDataProperty->setAccessible(true);

        $this->assertSame('https://example.com/api', $urlProperty->getValue($httpFetch));
        $this->assertSame('{"test": "data"}', $postDataProperty->getValue($httpFetch));
    }

    public function testSetCurlOptions(): void
    {
        $httpFetch = new HttpFetch('https://example.com/api', '{}');

        $httpFetch->setCurlOptions([
            \CURLOPT_TIMEOUT => 30,
            \CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $reflection = new ReflectionClass($httpFetch);
        $curlOptionsProperty = $reflection->getProperty('curlOptions');
        $curlOptionsProperty->setAccessible(true);

        $curlOptions = $curlOptionsProperty->getValue($httpFetch);
        $this->assertSame(30, $curlOptions[\CURLOPT_TIMEOUT]);
        $this->assertSame(10, $curlOptions[\CURLOPT_CONNECTTIMEOUT]);
    }

    public function testSetCurlOptionsOverwritesPreviousOptions(): void
    {
        $httpFetch = new HttpFetch('https://example.com/api', '{}');

        $httpFetch->setCurlOptions([\CURLOPT_TIMEOUT => 30]);
        $httpFetch->setCurlOptions([\CURLOPT_TIMEOUT => 60]);

        $reflection = new ReflectionClass($httpFetch);
        $curlOptionsProperty = $reflection->getProperty('curlOptions');
        $curlOptionsProperty->setAccessible(true);

        $curlOptions = $curlOptionsProperty->getValue($httpFetch);
        $this->assertSame(60, $curlOptions[\CURLOPT_TIMEOUT]);
        $this->assertArrayNotHasKey(\CURLOPT_CONNECTTIMEOUT, $curlOptions);
    }
}
