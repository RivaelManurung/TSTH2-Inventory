<!-- MODAL TAMBAH -->
<div class="modal fade" data-bs-backdrop="static" id="modaldemo9">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Barang Masuk</h6><button onclick="reset()" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bmkode" class="form-label">Kode Barang Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="bmkode" readonly class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglmasuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="tglmasuk" class="form-control datepicker-date" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="pengecek" class="form-label">Pilih Pengecek <span class="text-danger">*</span></label>
                            <select name="pengecek" id="pengecek" class="form-control">
                                <option value="">-- Pilih Pengecek --</option>
                                @foreach ($pengecek as $c)
                                <option value="{{ $c->pengecek_id }}">{{ $c->pengecek_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Barang <span class="text-danger me-1">*</span>
                                <input type="hidden" id="status" value="false">
                                <div class="spinner-border spinner-border-sm d-none" id="loaderkd" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" autocomplete="off" name="kdbarang" placeholder="" id="barcode-input">
                                <button class="btn btn-primary-light" onclick="searchBarang()" type="button"><i class="fe fe-search"></i></button>
                                <button class="btn btn-success-light" onclick="modalBarang()" type="button"><i class="fe fe-box"></i></button>
                                <button class="btn btn-warning-light" onclick="scanBarcode()" type="button"><i class="fe fe-camera"></i> Scan</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="nmbarang" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuan" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <input type="text" class="form-control" id="jenis" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jml" class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="jml" value="0" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkForm()" id="btnSimpan" class="btn btn-primary">Simpan <i class="fe fe-check"></i></a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="reset()" data-bs-dismiss="modal">Batal <i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>

@section('formScanTambahJS')
<script>
    // Ketika barcode dipindai, dapatkan data barang
    $('#barcode').on('input', function () {
        var barcode = $(this).val();
        if (barcode.length > 0) {
            // Panggil API untuk mendapatkan data barang berdasarkan barcode
            $.ajax({
                type: 'GET',
                url: "{{ url('admin/barang/getbarang') }}/" + barcode,
                dataType: 'json',
                success: function (data) {
                    if (data.length > 0) {
                        $('#barangDetails').show();
                        $("#nmbarang").val(data[0].barang_nama);
                        $("#satuan").val(data[0].satuan_nama);
                        $("#jenis").val(data[0].jenisbarang_nama);
                    } else {
                        alert('Barang tidak ditemukan');
                        $('#barangDetails').hide();
                    }
                }
            });
        } else {
            $('#barangDetails').hide();
        }
    });

    // Fungsi untuk menyimpan data barang masuk
    function submitScan() {
        var barcode = $('#barcode').val();
        var nmbarang = $('#nmbarang').val();
        var satuan = $('#satuan').val();
        var jenis = $('#jenis').val();
        var tglmasuk = $("input[name='tglmasuk']").val();
        var jml = $("input[name='jml']").val();
        var pengecek = $("select[name='pengecek']").val();

        // Validasi input
        if (!tglmasuk || !jml || !pengecek) {
            alert('Harap lengkapi semua data!');
            return;
        }

        $.ajax({
            type: 'POST',
            url: "{{ route('barang-masuk.store') }}",
            data: {
                barcode: barcode,
                tglmasuk: tglmasuk,
                jml: jml,
                pengecek: pengecek,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                alert('Barang berhasil ditambahkan!');
                // Reset Form
                $('#barcode').val('');
                $('#barangDetails').hide();
                $("input[name='tglmasuk']").val('');
                $("input[name='jml']").val('0');
                $("select[name='pengecek']").val('');
            },
            error: function () {
                alert('Terjadi kesalahan!');
            }
        });
    }
</script>
@endsection
