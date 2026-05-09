<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use Webmozart\Assert\Assert;

class HttpFetch
{
    /** @var array<int, mixed> */
    private array $curlOptions = [];

    public function __construct(
        private readonly string $url,
        private readonly string $postData,
    ) {}

    /** @param array<int, mixed> $curlOptions */
    public function setCurlOptions(array $curlOptions): void
    {
        $this->curlOptions = $curlOptions;
    }

    /**
     * @throws HttpFetchNoResultException
     */
    public function send(): string
    {
        $curlVersionInfo = curl_version();
        Assert::isArray($curlVersionInfo);
        $curlVersionNumber = $curlVersionInfo['version_number'];

        $curlResource = curl_init($this->url);
        curl_setopt($curlResource, \CURLOPT_POST, true);

        if ($curlVersionNumber >= 0x07_21_06) {
            curl_setopt($curlResource, \CURLOPT_ACCEPT_ENCODING, '');
        } elseif ($curlVersionNumber >= 0x07_15_06) {
            curl_setopt($curlResource, \CURLOPT_ENCODING, '');
        }

        curl_setopt($curlResource, \CURLOPT_POSTFIELDS, $this->postData);
        curl_setopt($curlResource, \CURLOPT_RETURNTRANSFER, true);

        foreach ($this->curlOptions as $option => $value) {
            curl_setopt($curlResource, $option, $value);
        }

        $result = curl_exec($curlResource);

        if ($result === false) {
            $info = curl_error($curlResource);
            $pException = new HttpFetchNoResultException($info);
            $pException->setCurlErrno(curl_errno($curlResource));

            throw $pException;
        }

        Assert::string($result);

        return $result;
    }
}
