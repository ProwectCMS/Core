<?php

namespace ProwectCMS\Core\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ProwectCMS\Core\Library\Account\AccountCredentialFactory;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'type' => 'required'
        ]);

        $type = $request->input('type');

        $this->validateType($type);

        $auth = Auth::guard('prowectcms');
        $credentials = $request->all();

        if ($auth->once($credentials)) {
            $account = $auth->user();

            $name = 'api';
            $abilities = ['*']; // TODO: implement scopes/abilities

            $token = $account->createToken($name, $abilities);

            return response()->json([
                'status' => 'ok',
                'key' => 'auth.login.success',
                'message' => 'Login succeeded',
                'token' => $token->plainTextToken
            ]);
        }

        return response()->json([
            'status' => 'error',
            'key' => 'auth.login.failed',
            'message' => 'Login failed'
        ], 400);
    }

    public function logout(Request $request)
    {
        $currentUser = $request->user();
        $currentToken = $currentUser->currentAccessToken()->token;

        if ($currentToken) {
            $currentUser->tokens()->where('token', $currentToken)->delete();
        }

        return response()->json([
            'status' => 'ok',
            'key' => 'auth.logout.success',
            'message' => 'Logout succeeded'
        ]);
    }

    public function user(Request $request)
    {
        $currentUser = $request->user();

        return response()->json($currentUser);
    }

    protected function validateType(string $type)
    {
        $accountCredentialFactory = App::make(AccountCredentialFactory::class);

        $validator = Validator::make([
            'type' => strtoupper($type)
        ], [
            'type' => ['required', 'filled', Rule::in($accountCredentialFactory->getAvailableNames())]
        ]);

        return $validator->validate();
    }
}