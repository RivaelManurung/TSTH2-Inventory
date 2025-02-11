<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SatuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index()
    {
        try {
            $satuans = SatuanModel::orderBy('satuan_id', 'DESC')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Daftar Satuan',
                'data' => $satuans
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data satuan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $satuan = SatuanModel::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Detail Satuan',
                'data' => $satuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'satuan_nama' => 'required|string|max:255',
            'satuan_keterangan' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->satuan_nama)));

            $satuan = SatuanModel::create([
                'satuan_nama' => $request->satuan_nama,
                'satuan_slug' => $slug,
                'satuan_keterangan' => $request->satuan_keterangan ?? '',
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil ditambahkan',
                'data' => $satuan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan satuan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'satuan_nama' => 'required|string|max:255',
            'satuan_keterangan' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $satuan = SatuanModel::findOrFail($id);

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->satuan_nama)));

            $satuan->update([
                'satuan_nama' => $request->satuan_nama,
                'satuan_slug' => $slug,
                'satuan_keterangan' => $request->satuan_keterangan ?? '',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil diupdate',
                'data' => $satuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate satuan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $satuan = SatuanModel::findOrFail($id);
            $satuan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus satuan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
