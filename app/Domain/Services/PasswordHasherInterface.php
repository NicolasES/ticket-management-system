<?php

namespace App\Domain\Services;

interface PasswordHasherInterface {
    public function check(string $plainPassword, string $hashedPassword): bool;
}
