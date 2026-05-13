<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Exception;

use BytesCommerce\OnOffice\Exception\ApiCallFaultyResponseException;
use BytesCommerce\OnOffice\Exception\ApiCallNoActionParametersException;
use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use BytesCommerce\OnOffice\Exception\SDKException;
use PHPUnit\Framework\TestCase;

final class SDKExceptionTest extends TestCase
{
    public function testApiCallFaultyResponseException(): void
    {
        $exception = new ApiCallFaultyResponseException('Handle: 123');

        $this->assertInstanceOf(SDKException::class, $exception);
        $this->assertSame('Handle: 123', $exception->getMessage());
    }

    public function testApiCallNoActionParametersException(): void
    {
        $exception = new ApiCallNoActionParametersException();

        $this->assertInstanceOf(SDKException::class, $exception);
    }

    public function testHttpFetchNoResultException(): void
    {
        $exception = new HttpFetchNoResultException();

        $this->assertInstanceOf(SDKException::class, $exception);
        $this->assertSame(0, $exception->getCurlErrno());
    }

    public function testHttpFetchNoResultExceptionWithCurlErrno(): void
    {
        $exception = new HttpFetchNoResultException();
        $exception->setCurlErrno(123);

        $this->assertSame(123, $exception->getCurlErrno());
    }

    public function testHttpFetchNoResultExceptionWithMessage(): void
    {
        $exception = new HttpFetchNoResultException('Connection failed');

        $this->assertSame('Connection failed', $exception->getMessage());
    }
}
