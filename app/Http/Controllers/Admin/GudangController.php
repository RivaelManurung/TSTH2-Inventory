<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GudangController extends Controller
{
    public function index()
    {
        try {
            $gudangs = GudangModel::orderBy('gudang_id', 'DESC')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Daftar Gudang',
                'data' => $gudangs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data gudang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $gudang = GudangModel::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Detail Gudang',
                'data' => $gudang
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gudang tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gudang' => 'required|string|max:255',
            'ket' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->gudang)));

            $gudang = GudangModel::create([
                'gudang_nama' => $request->gudang,
                'gudang_slug' => $slug,
                'gudang_keterangan' => $request->ket ?? '',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gudang berhasil ditambahkan',
                'data' => $gudang
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan gudang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gudang' => 'required|string|max:255',
            'ket' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $gudang = GudangModel::findOrFail($id);

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->gudang)));

            $gudang->update([
                'gudang_nama' => $request->gudang,
                'gudang_slug' => $slug,
                'gudang_keterangan' => $request->ket ?? '',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gudang berhasil diupdate',
                'data' => $gudang
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate gudang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $gudang = GudangModel::findOrFail($id);
            $gudang->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gudang berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gudang',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}