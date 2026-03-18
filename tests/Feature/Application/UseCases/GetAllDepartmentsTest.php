<?php

use App\Application\DAOs\DepartmentDAO;
use App\Application\UseCases\GetAllDepartments;
use Mockery\MockInterface;

test('should return all departments', function () {
    // 1. Arrange: Mocar a Interface do DAO para retornar dados falsos
    $daoMock = Mockery::mock(DepartmentDAO::class, function (MockInterface $mock) {
        $mock->shouldReceive('findAll')
            ->once()
            ->andReturn([
                ['id' => 1, 'name' => 'Departamento TI'],
                ['id' => 2, 'name' => 'Recursos Humanos'],
            ]);
    });

    // Injetar o mock na nossa classe principal
    $useCase = new GetAllDepartments($daoMock);

    // 2. Act: Executar a listagem
    $result = $useCase->execute();

    // 3. Assert: Verificar se o use case retornou exatamente o que o DAO repassou
    expect($result)->toBeArray();
    expect($result)->toHaveCount(2);
    expect($result[0]['id'])->toBe(1);
    expect($result[0]['name'])->toBe('Departamento TI');
    expect($result[1]['id'])->toBe(2);
    expect($result[1]['name'])->toBe('Recursos Humanos');
});
