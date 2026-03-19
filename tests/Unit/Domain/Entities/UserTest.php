<?php

use App\Domain\Entities\User;

test('should create a new user', function () {
    $user = new User('test@test.com', 'Test', 'password', '1');
    expect($user->getId())->toBeNull();
    expect($user->getEmail())->toBe('test@test.com');
    expect($user->getName())->toBe('Test');
    expect($user->getPassword())->toBe('password');
    expect($user->getDepartmentId())->toBe('1');
});

test('should set the id of a user', function () {
    $user = new User('test@test.com', 'Test', 'password', '1');
    $user->setId(1);
    expect($user->getId())->toBe(1);
});