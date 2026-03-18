<?php

use App\Models\DepartmentModel;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyFeature(Features::registration());
});

test('registration screen can be rendered', function () {
    DepartmentModel::factory()->create(['name' => 'Geral']);

    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    DepartmentModel::factory()->create(['name' => 'Geral']);

    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});