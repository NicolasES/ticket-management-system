<?php

namespace App\Domain\Exceptions;

class NotFoundException extends DomainException {
    public function __construct(string $message) {
        parent::__construct($message);
    }
}