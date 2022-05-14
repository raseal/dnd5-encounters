<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Domain\ValueObject\PositiveInteger;

final class Offset extends PositiveInteger
{
    public static function fromPage(int $page, int $limit): self
    {
        return new self(($page-1) * $limit);
    }
}
