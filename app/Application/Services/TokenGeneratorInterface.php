<?php

namespace App\Application\Services;

use App\Domain\Entities\User;

interface TokenGeneratorInterface {
    public function generate(User $user): string;
}
