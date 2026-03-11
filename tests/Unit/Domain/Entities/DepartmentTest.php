<?php
 
use App\Domain\Entities\Department;

test('should create a new department', function () {
    $department = new Department('Test');
    expect($department->getId())->toBeNull();
    expect($department->getName())->toBe('Test');
});

test('should set the id of a department', function () {
    $department = new Department('Test');
    $department->setId(1);
    expect($department->getId())->toBe(1);
});