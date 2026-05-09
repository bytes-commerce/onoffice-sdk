<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

use Webmozart\Assert\Assert;

final class Request implements RequestInterface
{
    private static int $requestIdStatic = 0;

    private int $_requestId;

    public function __construct(
        private readonly ApiAction $pApiAction,
        private readonly TimeProviderInterface $timeProvider = new SystemTimeProvider(),
    ) {
        $this->_requestId = self::$requestIdStatic++;
    }

    /** @return array<string, mixed> */
    public function createRequest(string $token, string $secret): array
    {
        $actionParameters = $this->pApiAction->getActionParameters();

        $actionParameters['timestamp'] ??= $this->timeProvider->time();
        $actionParameters['hmac_version'] = 2;

        $actionId = $actionParameters['actionid'];
        Assert::string($actionId);
        Assert::notEmpty($actionId);
        $type = $actionParameters['resourcetype'];
        Assert::string($type);
        Assert::notEmpty($type);
        $timestamp = $actionParameters['timestamp'];
        Assert::integer($timestamp);

        $hmac = $this->createHmac2($token, $secret, $timestamp, $type, $actionId);
        $actionParameters['hmac'] = $hmac;

        return $actionParameters;
    }

    public function getRequestId(): int
    {
        return $this->_requestId;
    }

    public function getApiAction(): ApiAction
    {
        return $this->pApiAction;
    }

    private function createHmac2(string $token, string $secret, int $timestamp, string $type, string $actionId): string
    {
        $fields = [
            'timestamp' => $timestamp,
            'token' => $token,
            'resourcetype' => $type,
            'actionid' => $actionId,
        ];

        return base64_encode(hash_hmac('sha256', implode('', $fields), $secret, true));
    }
}
