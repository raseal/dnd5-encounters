<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria\Filter\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidFilter extends DomainError
{
    public function __construct(
        private string $filter,
        private string $operator
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid-filter';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The filter combination <%s> and <%s> is not allowed',
            $this->filter,
            $this->operator
        );
    }
}
