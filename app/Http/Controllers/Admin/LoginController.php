<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // Import Role model
use Spatie\Permission\Models\Permission;

class LoginController extends BaseController
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|exists:roles,name', // role_name instead of role_id
                'user_nama' => 'required|string|max:255',
                'user_nmlengkap' => 'required|string|max:255',
                'user_email' => 'required|email|unique:tbl_user,user_email',
                'user_password' => 'required|min:6',
                'c_password' => 'required|same:user_password',
            ]);
    
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }
    
            $input = $request->all();
    
            // Hash the password
            $input['user_password'] = Hash::make($input['user_password']);
    
            // Handle file upload if exists
            if ($request->hasFile('user_foto')) {
                $file = $request->file('user_foto');
                $filePath = $file->store('uploads/users', 'public');
                $input['user_foto'] = $filePath;
            }
    
            // Create the user
            $user = UserModel::create($input);
    
            // Assign the role using Spatie's permission package (find role by name)
            $role = Role::findByName($request->role_name); // Get the role by name
            $user->assignRole($role); // Assign role to the user
    
            return $this->sendResponse([
                'user' => [
                    'user_nama' => $user->user_nama,
                    'user_nmlengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'user_foto' => $user->user_foto ? asset('storage/' . $user->user_foto) : null,
                    'role' => $role->name, 
                    'updated_at' => $user->updated_at,
                    'created_at' => $user->created_at,
                    'user_id' => $user->user_id
                ]
            ], 'User registered successfully.', 201);
        } catch (Exception $e) {
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

            // Check user roles and permissions
            $userRole = $user->getRoleNames()->first(); // Get the first role assigned to the user

            // Create a token manually since you're not using typical Laravel authentication
            $token = auth()->login($user);

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => [
                    'user_nama' => $user->user_nama,
                    'user_namalengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'user_foto' => $user->user_foto ? asset('storage/' . $user->user_foto) : null,
                    'role' => $userRole, // Include the role in the response
                ],
            ], 'User logged in successfully.', 200);
        } catch (Exception $e) {
            \Log::error('Login Error: ' . $e->getMessage());
            return $this->sendError('Server Error.', ['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (!auth()->check()) {
                return $this->sendError('Logout Failed.', ['error' => 'User is not logged in.'], 400);
            }

            // Logout with JWT
            auth()->logout();

            return $this->sendResponse([], 'Successfully logged out.', 200);
        } catch (Exception $e) {
            \Log::error('Logout Error: ' . $e->getMessage());
            return $this->sendError('Logout Failed.', ['error' => $e->getMessage()], 500);
        }
    }
}
