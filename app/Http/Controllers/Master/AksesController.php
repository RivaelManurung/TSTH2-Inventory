<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\MenuModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\SubmenuModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AksesController extends Controller
{
    public function index($role): JsonResponse
    {
        $roleData = $role === 'role' ? null : RoleModel::where('role_id', $role)->first();
        $menus = MenuModel::where('menu_type', '1')->orderBy('menu_sort', 'ASC')->get();
        $submenus = MenuModel::where('menu_type', '2')->orderBy('menu_sort', 'ASC')->get();
        
        return response()->json([
            'title' => 'Akses',
            'role_id' => $role === 'role' ? null : $role,
            'role' => RoleModel::latest()->get(),
            'detail_role' => $roleData,
            'menu' => $menus,
            'submenu' => $submenus,
        ]);
    }

    public function addAkses(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_id' => 'nullable|integer',
            'submenu_id' => 'nullable|integer',
            'othermenu_id' => 'nullable|integer',
            'role_id' => 'required|integer',
            'akses_type' => 'required|string',
        ]);
        
        AksesModel::create($validated);
        return response()->json(['message' => 'Akses berhasil ditambahkan'], 201);
    }

    public function removeAkses(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_id' => 'nullable|integer',
            'submenu_id' => 'nullable|integer',
            'othermenu_id' => 'nullable|integer',
            'role_id' => 'required|integer',
            'akses_type' => 'required|string',
        ]);

        AksesModel::where($validated)->delete();
        return response()->json(['message' => 'Akses berhasil dihapus']);
    }

    public function setAllAkses($idrole): JsonResponse
    {
        AksesModel::where('role_id', $idrole)->delete();
        
        $data = [];
        $menus = MenuModel::orderBy('menu_sort', 'ASC')->get();
        foreach ($menus as $m) {
            foreach (['view', 'create', 'update', 'delete'] as $type) {
                $data[] = [
                    'menu_id' => $m->menu_id,
                    'role_id' => $idrole,
                    'akses_type' => $type,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        $submenus = SubmenuModel::orderBy('submenu_sort', 'ASC')->get();
        foreach ($submenus as $sb) {
            foreach (['view', 'create', 'update', 'delete'] as $type) {
                $data[] = [
                    'submenu_id' => $sb->submenu_id,
                    'role_id' => $idrole,
                    'akses_type' => $type,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        for ($i = 1; $i <= 6; $i++) {
            foreach (['view', 'create', 'update', 'delete'] as $type) {
                $data[] = [
                    'othermenu_id' => $i,
                    'role_id' => $idrole,
                    'akses_type' => $type,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        AksesModel::insert($data);
        return response()->json(['message' => 'Semua akses berhasil diatur']);
    }

    public function unsetAllAkses($idrole): JsonResponse
    {
        AksesModel::where('role_id', $idrole)->delete();
        return response()->json(['message' => 'Semua akses berhasil dihapus']);
    }
}
