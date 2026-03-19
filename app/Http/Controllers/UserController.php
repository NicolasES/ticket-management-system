<?php 

namespace App\Http\Controllers;

use App\Application\UseCases\CreateUser;
use App\Application\DTOs\Input\CreateUserInput;
use Illuminate\Http\Request;

class UserController {
    public function __construct(
        private CreateUser $createUserUseCase
    ) {}
    public function __invoke(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);
        $input = new CreateUserInput(
            $request->name,
            $request->email,
            $request->password,
            $request->department_id
        );
        return $this->createUserUseCase->execute($input);
    }
}