<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes;

interface AttributeInterface
{
    public function getName(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function getTableName(): ?string;

    public function getContent(): ?string;

    public function getLength(): ?int;

    public function getDefault(): mixed;

    /**
     * @return array<string, string>|null
     */
    public function getPermittedValues(): ?array;

    public function hasPermittedValues(): bool;

    public function isSelect(): bool;

    public function isMultiSelect(): bool;

    public function isNumeric(): bool;

    public function isBoolean(): bool;

    public function isDate(): bool;

    public function isDateTime(): bool;

    public function isText(): bool;

    public function isInteger(): bool;

    public function isFloat(): bool;
}
