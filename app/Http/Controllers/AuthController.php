<?php

namespace App\Http\Controllers;

use App\Application\UseCases\LoginUser;
use App\Application\DTOs\Input\LoginUserInput;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function __construct(
        private LoginUser $loginUseCase
    ) {}

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
