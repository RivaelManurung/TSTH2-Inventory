<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AksesModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class AksesController extends BaseController
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->hasRole('superadmin', 'api')) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            return $next($request);
        });
    }

    public function getAksesByRole($role_id)
    {
        try {
            $role = Role::findById($role_id, 'api');
            if (!$role) {
                return response()->json(['error' => 'Role not found'], 404);
            }

            $akses = AksesModel::where('role_id', $role_id)->get();
            if ($akses->isEmpty()) {
                return response()->json(['error' => 'No access found for this role'], 404);
            }

            return response()->json(['data' => $akses, 'message' => 'Access data retrieved successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Server Error', 'details' => $e->getMessage()], 500);
        }
    }

    public function addAkses(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role_id' => 'required|exists:roles,id',
                'menu_id' => 'nullable|exists:tbl_menu,menu_id',
                'submenu_id' => 'nullable|exists:tbl_submenu,submenu_id',
                'akses_type' => 'required|string'
            ]);

            $akses = AksesModel::create($validatedData);
            return response()->json(['data' => $akses, 'message' => 'Access added successfully'], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation Error', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to add access', 'details' => $e->getMessage()], 500);
        }
    }

    public function removeAkses(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role_id' => 'required|exists:roles,id',
                'menu_id' => 'nullable|exists:tbl_menu,menu_id',
                'submenu_id' => 'nullable|exists:tbl_submenu,submenu_id',
                'akses_type' => 'required|string'
            ]);

            $deleted = AksesModel::where($validatedData)->delete();

            if ($deleted) {
                return response()->json(['message' => 'Access deleted successfully'], 200);
            }
            return response()->json(['error' => 'Access not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation Error', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to remove access', 'details' => $e->getMessage()], 500);
        }
    }

    public function setAllAkses($role_id)
    {
        try {
            $role = Role::findById($role_id, 'api');
            if (!$role) {
                return response()->json(['error' => 'Role not found'], 404);
            }

            AksesModel::where('role_id', $role_id)->delete();
            $data = [];

            foreach (MenuModel::all() as $menu) {
                foreach (['view', 'create', 'update', 'delete'] as $type) {
                    $data[] = ['menu_id' => $menu->menu_id, 'role_id' => $role_id, 'akses_type' => $type, 'created_at' => now(), 'updated_at' => now()];
                }
            }

            foreach (SubmenuModel::all() as $submenu) {
                foreach (['view', 'create', 'update', 'delete'] as $type) {
                    $data[] = ['submenu_id' => $submenu->submenu_id, 'role_id' => $role_id, 'akses_type' => $type, 'created_at' => now(), 'updated_at' => now()];
                }
            }

            AksesModel::insert($data);
            return response()->json(['message' => 'All access set successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to set all access', 'details' => $e->getMessage()], 500);
        }
    }

    public function unsetAllAkses($role_id)
    {
        try {
            $deleted = AksesModel::where('role_id', $role_id)->delete();
            if ($deleted) {
                return response()->json(['message' => 'All access removed successfully'], 200);
            }
            return response()->json(['error' => 'Failed to remove access'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to remove access', 'details' => $e->getMessage()], 500);
        }
    }
}
