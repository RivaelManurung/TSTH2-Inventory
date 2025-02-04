<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:tbl_role,role_id',
                'user_nama' => 'required|string|max:255', // Ensure this field is present
                'user_nmlengkap' => 'required|string|max:255',
                'user_email' => 'required|email|unique:tbl_user,user_email',
                'user_password' => 'required|min:6',
                'c_password' => 'required|same:user_password',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $input = $request->all();

            // Use Hash instead of bcrypt for Laravel standard password hashing
            $input['user_password'] = Hash::make($input['user_password']);

            if ($request->hasFile('user_foto')) {
                $file = $request->file('user_foto');
                $filePath = $file->store('uploads/users', 'public');
                $input['user_foto'] = $filePath;
            }

            $user = UserModel::create($input);

            return $this->sendResponse(['user' => $user], 'User registered successfully.', 201);
        } catch (Exception $e) {
            // Log the full error for debugging
            \Log::error('Registration Error: ' . $e->getMessage());
            return $this->sendError('Server Error.', ['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_email' => 'required|email',
                'user_password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $credentials = [
                'user_email' => $request->user_email,
                'password' => $request->user_password,
            ];

            $user = UserModel::where('user_email', $request->user_email)->first();

            if (!$user || !Hash::check($request->user_password, $user->user_password)) {
                return $this->sendError('Login Failed.', ['error' => 'Invalid email or password'], 401);
            }

            // Create a token manually since you're not using typical Laravel authentication
            $token = auth()->login($user);

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => [
                    'role_id' => $user->role_id,
                    'user_nama' => $user->user_nama,
                    'user_namalengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'user_foto' => $user->user_foto ? asset('storage/' . $user->user_foto) : null,
                ],
            ], 'User logged in successfully.', 200);
        } catch (Exception $e) {
            // Log the full error for debugging
            \Log::error(message: 'Login Error: ' . $e->getMessage());
            return $this->sendError('Server Error.', ['error' => $e->getMessage()], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            // Periksa apakah user sudah login
            if (!auth()->check()) {
                return $this->sendError('Logout Failed.', ['error' => 'User is not logged in.'], 400);
            }

            // Logout dengan JWT
            auth()->logout();

            return $this->sendResponse([], 'Successfully logged out.', 200);
        } catch (Exception $e) {
            // Log error untuk debugging
            \Log::error('Logout Error: ' . $e->getMessage());
            return $this->sendError('Logout Failed.', ['error' => $e->getMessage()], 500);
        }
    }
}
