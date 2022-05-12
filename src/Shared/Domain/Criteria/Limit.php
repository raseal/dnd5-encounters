<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Domain\ValueObject\PositiveInteger;

final class Limit extends PositiveInteger
{
    private const DEFAULT_VALUE = 10;

    public function __construct(int $value)
    {
        parent::__construct(
            (0 === $value) ? self::DEFAULT_VALUE : $value
        );
    }
}
