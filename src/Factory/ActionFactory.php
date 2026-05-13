<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Factory;

use BytesCommerce\OnOffice\Action\ActionBase;
use BytesCommerce\OnOffice\Action\ActionInterface;
use BytesCommerce\OnOffice\Api;
use InvalidArgumentException;
use SensitiveParameter;

final class ActionFactory
{
    public function create(string $actionClass, #[SensitiveParameter] string $token, #[SensitiveParameter] string $secret, ?Api $sdk = null): ActionInterface
    {
        if (!is_subclass_of($actionClass, ActionBase::class)) {
            throw new InvalidArgumentException(
                \sprintf(
                    'Action class "%s" must be a subclass of %s',
                    $actionClass,
                    ActionBase::class,
                ),
            );
        }

        return new $actionClass($token, $secret, $sdk);
    }
}
