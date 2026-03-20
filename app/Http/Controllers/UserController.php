<?php 

namespace App\Http\Controllers;

use App\Application\UseCases\CreateUser;
use App\Application\DTOs\Input\CreateUserInput;
use Illuminate\Http\Request;

class UserController {
    public function __construct(
        private CreateUser $createUserUseCase
    ) {}

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'departmentId' => 'required|integer'
        ]);
        $input = new CreateUserInput(
            $request->email,
            $request->name,
            $request->password,
            $request->departmentId
        );
        $output = $this->createUserUseCase->execute($input);
        return response()->json($output);
    }
}