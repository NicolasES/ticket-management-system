<?php

namespace App\Http\Controllers;

use App\Application\UseCases\GetUsersByDepartmentId;
use Illuminate\Http\JsonResponse;

class DepartmentUserController extends Controller
{
    public function __construct(
        private GetUsersByDepartmentId $getUsersByDepartmentIdUseCase
    ) {}

    public function index(int $departmentId): JsonResponse
    {
        $users = $this->getUsersByDepartmentIdUseCase->execute($departmentId);
        return response()->json($users);
    }
}
