<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\Admin\AksesModel;
// use App\Models\Admin\BarangkeluarModel;
// use App\Models\Admin\BarangmasukModel;
// use App\Models\Admin\BarangModel;
// use App\Models\Admin\JenisBarangModel;
// use App\Models\Admin\GudangModel;
// use App\Models\Admin\SatuanModel;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

// class BarangController extends Controller
// {
//     public function index()
//     {
//         try {
//             $barang = BarangModel::with(['jenisBarang', 'satuan', 'gudang'])->get()->map(function ($item) {
//                 if (!is_null($item->barcode)) {
//                     $item->barcodeUrl = asset('storage/barang/barcodes/' . $item->barcode);
//                 } else {
//                     $item->barcodeUrl = null;
//                 }
//                 return $item;
//             });

//             return response()->json([
//                 'status' => 'success',
//                 'data' => [
//                     'barang' => $barang,
//                     'jenisbarang' => JenisBarangModel::orderBy('jenisbarang_id', 'DESC')->get(),
//                     'satuan' => SatuanModel::orderBy('satuan_id', 'DESC')->get(),
//                     'gudang' => GudangModel::orderBy('gudang_id', 'DESC')->get()
//                 ]
//             ]);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function getBarang($id)
//     {
//         try {
//             $barang = BarangModel::with(['jenisBarang', 'satuan', 'gudang'])
//                 ->where('barang_kode', $id)
//                 ->first();

//             if (!$barang) {
//                 return response()->json([
//                     'status' => 'error',
//                     'message' => 'Barang not found'
//                 ], 404);
//             }

//             return response()->json([
//                 'status' => 'success',
//                 'data' => $barang
//             ]);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function store(Request $request)
//     {
//         try {
//             // Validate request
//             $request->validate([
//                 'nama' => 'required',
//                 'kode' => 'required|unique:tbl_barang,barang_kode',
//                 'jenisbarang' => 'required',
//                 'satuan' => 'required',
//                 'gudang' => 'required',
//                 'harga' => 'required|numeric',
//                 'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
//             ]);

//             $img = "image.png";
//             $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->nama)));

//             // Handle image upload
//             if ($request->hasFile('foto')) {
//                 $image = $request->file('foto');
//                 $image->storeAs('public/barang/', $image->hashName());
//                 $img = $image->hashName();
//             }

//             // Generate QR Code
//             $qrCodePath = 'public/barang/barcodes/' . $request->kode . '.png';
//             $qrCode = QrCode::format('png')->size(200)->generate($request->kode);
//             Storage::put($qrCodePath, $qrCode);
//             $qrCodeFileName = basename($qrCodePath);

//             // Create barang
//             $barang = BarangModel::create([
//                 'barang_gambar' => $img,
//                 'jenisbarang_id' => $request->jenisbarang,
//                 'satuan_id' => $request->satuan,
//                 'gudang_id' => $request->gudang,
//                 'barang_kode' => $request->kode,
//                 'barang_nama' => $request->nama,
//                 'barang_slug' => $slug,
//                 'barang_harga' => $request->harga,
//                 'barang_stok' => 0,
//                 'barcode' => $qrCodeFileName,
//             ]);

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Barang created successfully',
//                 'data' => $barang
//             ], 201);

//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function update(Request $request, $id)
//     {
//         try {
//             $barang = BarangModel::where('barang_kode', $id)->firstOrFail();
            
//             // Validate request
//             $request->validate([
//                 'nama' => 'required',
//                 'kode' => 'required|unique:tbl_barang,barang_kode,' . $barang->barang_id . ',barang_id',
//                 'jenisbarang' => 'required',
//                 'satuan' => 'required',
//                 'gudang' => 'required',
//                 'harga' => 'required|numeric',
//                 'stok' => 'required|numeric',
//                 'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
//             ]);

//             $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->nama)));

//             $updateData = [
//                 'jenisbarang_id' => $request->jenisbarang,
//                 'satuan_id' => $request->satuan,
//                 'gudang_id' => $request->gudang,
//                 'barang_kode' => $request->kode,
//                 'barang_nama' => $request->nama,
//                 'barang_slug' => $slug,
//                 'barang_harga' => $request->harga,
//                 'barang_stok' => $request->stok,
//             ];

//             if ($request->hasFile('foto')) {
//                 $image = $request->file('foto');
//                 $image->storeAs('public/barang', $image->hashName());
                
//                 // Delete old image if it exists and is not the default
//                 if ($barang->barang_gambar != 'image.png') {
//                     Storage::delete('public/barang/' . $barang->barang_gambar);
//                 }
                
//                 $updateData['barang_gambar'] = $image->hashName();
//             }

//             $barang->update($updateData);

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Barang updated successfully',
//                 'data' => $barang
//             ]);

//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $barang = BarangModel::where('barang_kode', $id)->firstOrFail();

//             // Delete image if it exists and is not the default
//             if ($barang->barang_gambar != 'image.png') {
//                 Storage::delete('public/barang/' . $barang->barang_gambar);
//             }

//             // Delete QR code if it exists
//             if ($barang->barcode) {
//                 Storage::delete('public/barang/barcodes/' . $barang->barcode);
//             }

//             $barang->delete();

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Barang deleted successfully'
//             ]);

//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function getStockCalculation(Request $request, $kode)
//     {
//         try {
//             $barang = BarangModel::where('barang_kode', $kode)->firstOrFail();
            
//             $query = BarangmasukModel::where('barang_kode', $kode);
//             $queryKeluar = BarangkeluarModel::where('barang_kode', $kode);

//             if ($request->has('start_date') && $request->has('end_date')) {
//                 $query->whereBetween('bm_tanggal', [$request->start_date, $request->end_date]);
//                 $queryKeluar->whereBetween('bk_tanggal', [$request->start_date, $request->end_date]);
//             }

//             $jmlmasuk = $query->sum('bm_jumlah');
//             $jmlkeluar = $queryKeluar->sum('bk_jumlah');
//             $totalstok = $barang->barang_stok + ($jmlmasuk - $jmlkeluar);

//             return response()->json([
//                 'status' => 'success',
//                 'data' => [
//                     'initial_stock' => $barang->barang_stok,
//                     'stock_in' => $jmlmasuk,
//                     'stock_out' => $jmlkeluar,
//                     'current_stock' => $totalstok
//                 ]
//             ]);

//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }
// }