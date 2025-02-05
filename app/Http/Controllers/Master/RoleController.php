<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Admin\BaseController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{
    /**
     * Menampilkan daftar semua role
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return $this->sendResponse($roles, 'Roles retrieved successfully.');
    }

    /**
     * Menyimpan role baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 400);
        }

        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return $this->sendResponse($role->load('permissions'), 'Role successfully created!');
    }

    /**
     * Menampilkan role berdasarkan ID
     */
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        
        if (!$role) {
            return $this->sendError('Role not found');
        }

        return $this->sendResponse($role, 'Role retrieved successfully.');
    }

    /**
     * Memperbarui role
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'array'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 400);
        }

        $role = Role::find($id);
        
        if (!$role) {
            return $this->sendError('Role not found');
        }

        $role->update([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return $this->sendResponse($role->load('permissions'), 'Role successfully updated!');
    }

    /**
     * Menghapus role
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        
        if (!$role) {
            return $this->sendError('Role not found');
        }

        $role->delete();

        return $this->sendResponse([], 'Role successfully deleted!');
    }

    /**
     * Mendapatkan semua permission yang tersedia
     */
    public function getAllPermissions()
    {
        $permissions = Permission::all();
        return $this->sendResponse($permissions, 'Permissions retrieved successfully.');
    }

    /**
     * Mendapatkan permission untuk role tertentu
     */
    public function getPermissions($id)
    {
        $role = Role::with('permissions')->find($id);
        
        if (!$role) {
            return $this->sendError('Role not found');
        }

        return $this->sendResponse($role->permissions, 'Role permissions retrieved successfully.');
    }

    /**
     * Mengatur permission untuk role tertentu
     */
    public function assignPermissions(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'permissions' => 'required|array'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 400);
        }

        $role = Role::find($id);
        
        if (!$role) {
            return $this->sendError('Role not found');
        }

        $role->syncPermissions($request->permissions);

        return $this->sendResponse($role->load('permissions'), 'Permissions assigned successfully.');
    }
}