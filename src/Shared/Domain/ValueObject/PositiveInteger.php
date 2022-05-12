<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Shared\Domain\Exception\InvalidPositiveInteger;

class PositiveInteger extends IntegerValueObject
{
    public function __construct(int $value)
    {
        $this->assertPositiveValue($value);
        parent::__construct($value);
    }

    private function assertPositiveValue(int $value): void
    {
        if ($value < 0) {
            throw new InvalidPositiveInteger($value);
        }
    }
}
