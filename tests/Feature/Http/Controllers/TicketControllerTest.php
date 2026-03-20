<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('should create a new ticket successfully', function () {
    $departmentId = DB::table('departments')->insertGetId([
        'name' => 'Suporte Técnico',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $user = User::factory()->create([
        'department_id' => $departmentId,
    ]);
    $payload = [
        'title' => 'Problema no computador',
        'description' => 'A tela está piscando.',
        'departmentId' => $departmentId,
    ];

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/tickets', $payload);

    $response->assertStatus(201)
             ->assertJson([
                 'title' => 'Problema no computador',
                 'description' => 'A tela está piscando.',
             ]);
    $this->assertDatabaseHas('tickets', [
        'title' => 'Problema no computador',
        'department_id' => $departmentId,
        'requester_id' => $user->id,
    ]);
});
