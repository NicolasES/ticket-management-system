<?php

use App\Domain\Entities\User;

test('should create a new user', function () {
    $user = new User('test@test.com', 'Test');
    expect($user->getEmail())->toBe('test@test.com');
    expect($user->getName())->toBe('Test');
});

test('should set the id of a user', function () {
    $user = new User('test@test.com', 'Test');
    $user->setId(1);
    expect($user->getId())->toBe(1);
});