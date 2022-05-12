<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

use function sprintf;

final class InvalidPositiveInteger extends DomainError
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        parent::__construct();
    }
    public function errorCode(): string
    {
        return 'Invalid_positive_integer';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The number %s is not positive',
            $this->value
        );
    }
}
