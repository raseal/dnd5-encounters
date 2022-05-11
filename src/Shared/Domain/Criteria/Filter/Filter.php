<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria\Filter;

class Filter
{
    public function __construct(
        protected FilterField $field,
        protected FilterOperator $operator,
        protected FilterValue $value
    ) {}

    public static function fromValues(string $filterField, string $operator, string $value): self
    {
        return new self(
            new FilterField($filterField),
            new FilterOperator($operator),
            new FilterValue($value)
        );
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }
}
