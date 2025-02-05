<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisBarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class JenisBarangController extends Controller
{
    public function index(): JsonResponse
    {
        $data = JenisBarangModel::orderBy('jenisbarang_id', 'DESC')->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function show($id): JsonResponse
    {
        $jenisBarang = JenisBarangModel::find($id);
        if (!$jenisBarang) {
            return response()->json(['success' => false, 'message' => 'Jenis barang tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $jenisBarang]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'jenisbarang_nama' => 'required|string|max:255',
            'jenisbarang_ket' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->jenisbarang_nama)));

        $jenisBarang = JenisBarangModel::create([
            'jenisbarang_nama' => $request->jenisbarang_nama,
            'jenisbarang_slug' => $slug,
            'jenisbarang_ket' => $request->jenisbarang_ket,
        ]);

        return response()->json(['success' => true, 'message' => 'Jenis barang berhasil ditambahkan', 'data' => $jenisBarang]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $jenisBarang = JenisBarangModel::find($id);
        if (!$jenisBarang) {
            return response()->json(['success' => false, 'message' => 'Jenis barang tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'jenisbarang_nama' => 'required|string|max:255',
            'jenisbarang_ket' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->jenisbarang_nama)));

        $jenisBarang->update([
            'jenisbarang_nama' => $request->jenisbarang_nama,
            'jenisbarang_slug' => $slug,
            'jenisbarang_ket' => $request->jenisbarang_ket,
        ]);

        return response()->json(['success' => true, 'message' => 'Jenis barang berhasil diperbarui', 'data' => $jenisBarang]);
    }

    public function destroy($id): JsonResponse
    {
        $jenisBarang = JenisBarangModel::find($id);
        if (!$jenisBarang) {
            return response()->json(['success' => false, 'message' => 'Jenis barang tidak ditemukan'], 404);
        }

        $jenisBarang->delete();

        return response()->json(['success' => true, 'message' => 'Jenis barang berhasil dihapus']);
    }
}
