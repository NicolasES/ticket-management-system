<?php

namespace App\Infrastructure\Services;

use App\Domain\Services\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

class LaravelPasswordHasher implements PasswordHasherInterface {
    public function check(string $plainPassword, string $hashedPassword): bool {
        return Hash::check($plainPassword, $hashedPassword);
    }
}
