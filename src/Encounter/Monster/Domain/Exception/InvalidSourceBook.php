<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidSourceBook extends DomainError
{
    private string $sourceBook;

    public function __construct(string $book)
    {
        $this->sourceBook = $book;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Sourcebook_does_not_exist';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The sourcebook %s does not exist',
            $this->sourceBook
        );
    }
}
