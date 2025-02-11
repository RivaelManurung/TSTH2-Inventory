<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AksesModel;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $menu, $type)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Ambil role ID dari Spatie berdasarkan role yang dimiliki user
        $roleName = $user->getRoleNames()->first(); // Ambil nama role pertama
        $role = Role::where('name', $roleName)->first(); // Ambil role dari database

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 403);
        }

        $roleId = $role->id; // Ambil role ID

        // Konversi menu ke integer jika berisi angka
        $menu = is_numeric($menu) ? (int) $menu : $menu;
        // dd([
        //     'user' => $user,
        //     'roleName' => $roleName,
        //     'roleId' => $roleId,
        //     'menu' => $menu,
        //     'type' => $type,
        // ]);
        // Debugging menu dan type sebelum query (aktifkan jika perlu)
        // dd(compact('menu', 'type'));

        $hasAccess = match ($type) {
            'othermenu' => DB::table('tbl_akses')
                ->where([
                    'role_id' => $roleId,
                    'othermenu_id' => $menu,
                    'akses_type' => 'view'
                ])->exists(),

            'menu' => AksesModel::leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_akses.menu_id')
                ->where([
                    'tbl_akses.role_id' => $roleId,
                    'tbl_menu.menu_redirect' => $menu,
                    'tbl_akses.akses_type' => 'view'
                ])->exists(),

            'submenu' => AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')
                ->where([
                    'tbl_akses.role_id' => $roleId,
                    'tbl_submenu.submenu_redirect' => $menu,
                    'tbl_akses.akses_type' => 'view'
                ])->exists(),

            default => false,
        };

        // Debugging hasil query (aktifkan jika perlu)
        // dd(compact('menu', 'type', 'roleId', 'hasAccess'));
        // dd(compact('menu', 'type', 'roleId', 'hasAccess')); // Debugging hasil query

        if (!$hasAccess) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
