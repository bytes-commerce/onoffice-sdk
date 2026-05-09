<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Cache;

interface cacheInterface
{
    /**
     * $parameter1['actionid'] = $myactionid;
     * $parameter1['resourcetype'] = $myresourceType;
     * $parameter1['parameters'] = $myparameters;
     * $parameter1['resourceid'] = $myresourceId;
     * $parameter1['identifier'] = $myidentifier;
     *
     * $parameters = array($parameter1, $parameter...);
     * see also <pre>ApiAction::getActionParameters()</pre> as these parameters are going to be used.
     *
     * @param array<string, mixed> $parameters
     *
     * @return string|null must return null if not in cache or a string on success
     */
    public function getHttpResponseByParameterArray(array $parameters): ?string;

    /**
     * @param array<string, mixed> $parameters requestParameters. See Above.
     * @param string $value the API response
     */
    public function write(array $parameters, string $value): bool;

    public function cleanup(): void;

    public function clearAll(): void;
}
