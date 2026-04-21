<?php

namespace App\Http\Controllers;

use App\Application\DTOs\Input\CreateDepartmentInput;
use App\Application\UseCases\CreateDepartment;
use App\Application\UseCases\GetAllDepartments;
use Illuminate\Http\Request;

class DepartmentController
{
    public function __construct(
        private readonly GetAllDepartments $getAllDepartments,
        private readonly CreateDepartment $createDepartment
    ) {}

    public function index()
    {
        $departments = $this->getAllDepartments->execute();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $input = new CreateDepartmentInput($request->name);
        $department = $this->createDepartment->execute($input);
        return response()->json($department);
    }
}
