<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('should create a new department successfully', function () {
    $payload = [
        'name' => 'Recursos Humanos'
    ];
    $response = $this->postJson('/api/departments', $payload);
    $response->assertStatus(200)
             ->assertJson([
                 'name' => 'Recursos Humanos'
             ]);
    $this->assertDatabaseHas('departments', [
        'name' => 'Recursos Humanos'
    ]);
});
