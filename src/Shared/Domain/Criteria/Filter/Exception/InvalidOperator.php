<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria\Filter\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidOperator extends DomainError
{
    public function __construct(
        private string $operator
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid-operator';
    }

    public function errorMessage(): string
    {
        return sprintf('Operator <%s> is not valid.', $this->operator);
    }
}
