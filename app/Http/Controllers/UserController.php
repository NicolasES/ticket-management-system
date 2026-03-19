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
            'department_id' => 'required|integer'
        ]);
        $input = new CreateUserInput(
            $request->name,
            $request->email,
            $request->password,
            $request->department_id
        );
        $output = $this->createUserUseCase->execute($input);
        return response()->json($output);
    }
}