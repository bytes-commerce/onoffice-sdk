<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Exception;

class HttpFetchNoResultException extends SDKException
{
    private int $curlErrno = 0;

    public function getCurlErrno(): int
    {
        return $this->curlErrno;
    }

    public function setCurlErrno(int $errno): void
    {
        $this->curlErrno = $errno;
    }
}
