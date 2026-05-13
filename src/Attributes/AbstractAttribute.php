<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes;

abstract readonly class AbstractAttribute
{
    public const string TYPE_VARCHAR = 'varchar';

    public const string TYPE_TEXT = 'text';

    public const string TYPE_INTEGER = 'integer';

    public const string TYPE_FLOAT = 'float';

    public const string TYPE_BOOLEAN = 'boolean';

    public const string TYPE_DATE = 'date';

    public const string TYPE_DATETIME = 'datetime';

    public const string TYPE_SINGLESELECT = 'singleselect';

    public const string TYPE_MULTISELECT = 'multiselect';

    /**
     * @param string $name Field name (snake_case)
     * @param string $label Human-readable label
     * @param string $type Field type (use constants: TYPE_VARCHAR, TYPE_INTEGER, TYPE_SINGLESELECT, etc.)
     * @param string|null $tablename Database table name
     * @param string|null $content Content category
     * @param int|null $length Field length (for varchar)
     * @param mixed $default Default value
     * @param array<string, string>|null $permittedValues Map of value => label for select types
     */
    public function __construct(
        private string $name,
        private string $label,
        private string $type,
        private ?string $tablename = null,
        private ?string $content = null,
        private ?int $length = null,
        private mixed $default = null,
        private ?array $permittedValues = null,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTableName(): ?string
    {
        return $this->tablename;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    /**
     * @return array<string, string>|null Map of value => label
     */
    public function getPermittedValues(): ?array
    {
        if ($this->permittedValues !== null) {
            return $this->permittedValues;
        }

        $enumClass = $this->getEnumClass();
        if ($enumClass === null || !enum_exists($enumClass)) {
            return null;
        }

        $cases = $enumClass::cases();
        if ($cases === []) {
            return null;
        }

        $values = [];
        foreach ($cases as $case) {
            // @phpstan-ignore-next-line label() is defined on the specific enum class
            $values[$case->value] = $case->label();
        }

        return $values;
    }

    public function hasPermittedValues(): bool
    {
        return $this->permittedValues !== null && $this->permittedValues !== [];
    }

    public function isSelect(): bool
    {
        return $this->type === self::TYPE_SINGLESELECT;
    }

    public function isMultiSelect(): bool
    {
        return $this->type === self::TYPE_MULTISELECT;
    }

    public function isNumeric(): bool
    {
        return \in_array($this->type, [self::TYPE_INTEGER, self::TYPE_FLOAT], true);
    }

    public function isBoolean(): bool
    {
        return $this->type === self::TYPE_BOOLEAN;
    }

    public function isDate(): bool
    {
        return $this->type === self::TYPE_DATE;
    }

    public function isDateTime(): bool
    {
        return $this->type === self::TYPE_DATETIME;
    }

    public function isText(): bool
    {
        return \in_array($this->type, [self::TYPE_TEXT, self::TYPE_VARCHAR], true);
    }

    public function isInteger(): bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat(): bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    /**
     * Returns the ENUM class associated with this attribute, if any.
     * Subclasses should override this method when they have an associated ENUM.
     */
    protected function getEnumClass(): ?string
    {
        return null;
    }
}
