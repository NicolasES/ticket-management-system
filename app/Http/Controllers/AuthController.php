<?php

namespace App\Http\Controllers;

use App\Application\UseCases\LoginUser;
use App\Application\DTOs\Input\LoginUserInput;
use App\Application\UseCases\ImpersonateUser;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function __construct(
        private LoginUser $loginUseCase,
        private ImpersonateUser $impersonateUseCase
    ) {}

    public function loginDirectly(int $userId) {
        try {
            $output = $this->impersonateUseCase->execute($userId);
            return response()->json($output);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $input = new LoginUserInput($request->email, $request->password);
            $output = $this->loginUseCase->execute($input);

            return response()->json($output);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}
