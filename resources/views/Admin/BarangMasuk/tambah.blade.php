<!-- Add html5-qrcode to your page -->
<script src="{{ url('/assets/js/html5-qrcode.min.js') }}"></script>

<!-- MODAL TAMBAH -->
<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Barang Masuk</h6>
                <button onclick="reset()" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bmkode" class="form-label">Kode Barang Masuk <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="bmkode" readonly class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglmasuk" class="form-label">Tanggal Masuk <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="tglmasuk" class="form-control datepicker-date" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="pengecek" class="form-label">Pilih Pengecek <span
                                    class="text-danger">*</span></label>
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
                                <input type="text" class="form-control" autocomplete="off" name="kdbarang"
                                    placeholder="">
                                <button class="btn btn-primary-light" onclick="searchBarang()" type="button"><i
                                        class="fe fe-search"></i></button>
                                <button class="btn btn-success-light" onclick="modalBarang()" type="button"><i
                                        class="fe fe-box"></i></button>
                                <button class="btn btn-warning-light" onclick="scanBarcode()" type="button"><i
                                        class="fe fe-camera"></i> Scan</button>
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
                            <input type="text" name="jml" value="0" class="form-control"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                                placeholder="">
                        </div>
                    </div>
                </div>

                <!-- Updated scanner container -->
                <div id="interactive" class="viewport"
                    style="position: relative; width: 100%; height: 300px; display: none;">
                    <video autoplay="true" preload="auto" style="width: 100%; height: 100%;"></video>
                    <canvas class="drawingBuffer" style="position: absolute; top: 0; left: 0;"></canvas>
                    <button class="btn btn-danger" style="position: absolute; top: 10px; right: 10px;"
                        onclick="stopScanning()">
                        <i class="fe fe-x"></i> Close Scanner
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="true">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkForm()" id="btnSimpan" class="btn btn-primary">Simpan <i
                        class="fe fe-check"></i></a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="reset()" data-bs-dismiss="modal">Batal <i
                        class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>

<style>
    .viewport {
        position: relative;
        width: 100%;
        height: 300px;
    }

    .viewport>video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .viewport>canvas {
        position: absolute;
        top: 0;
        left: 0;
    }

    .drawingBuffer {
        position: absolute;
        top: 0;
        left: 0;
    }
</style>

@section('formTambahJS')
<script>
    
    // Handle keypress on Kode Barang field
    $('input[name="kdbarang"]').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            getbarangbyid($('input[name="kdbarang"]').val());
        }
    });

    // Open Barang Modal
    function modalBarang() {
        $('#modalBarang').modal('show');
        $('#modaldemo8').addClass('d-none');
        $('input[name="param"]').val('tambah');
        resetValid();
        table2.ajax.reload();
    }

    // Search Barang by ID
    function searchBarang() {
        getbarangbyid($('input[name="kdbarang"]').val());
        resetValid();
    }

    // Fetch Barang details by ID
    function getbarangbyid(id) {
        $("#loaderkd").removeClass('d-none');
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/barang/getbarang') }}/" + id,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    $("#loaderkd").addClass('d-none');
                    $("#status").val("true");
                    $("#nmbarang").val(data[0].barang_nama);
                    $("#satuan").val(data[0].satuan_nama);
                    $("#jenis").val(data[0].jenisbarang_nama);
                } else {
                    $("#loaderkd").addClass('d-none');
                    $("#status").val("false");
                    $("#nmbarang").val('');
                    $("#satuan").val('');
                    $("#jenis").val('');
                }
            }
        });
    }

// Fungsi untuk memulai pemindaian barcode dengan html5-qrcode
function scanBarcode() {
    $('#interactive').show();

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        // Saat QR code berhasil dipindai
        $('input[name="kdbarang"]').val(decodedText);
        getbarangbyid(decodedText);
        stopScanning();  // Hentikan scanner setelah berhasil memindai
    };

    const qrCodeErrorCallback = (errorMessage) => {
        // Jika terjadi kesalahan pada pemindaian
        console.warn("QR code error: ", errorMessage);
    };

    const config = {
        fps: 10, // frames per second
        qrbox: 250, // ukuran kotak pemindaian
    };

    // Inisialisasi scanner HTML5
    const html5QrCode = new Html5Qrcode("interactive");

    // Mulai pemindaian
    html5QrCode.start(
        { facingMode: "environment" }, // menggunakan kamera belakang
        config,
        qrCodeSuccessCallback,
        qrCodeErrorCallback
    ).catch(err => {
        console.error("Error saat memulai scanner: ", err);
        alert("Error saat memulai scanner: " + err);
    });
}

// Fungsi untuk menghentikan scanner
function stopScanning() {
    const html5QrCode = new Html5Qrcode("interactive");
    html5QrCode.stop().then((ignore) => {
        // Sukses menghentikan pemindaian
        console.log("Scanner berhenti");
    }).catch((err) => {
        // Kesalahan saat menghentikan scanner
        console.error("Error saat menghentikan scanner: ", err);
    });
    $('#interactive').hide();  // Menyembunyikan elemen pemindaian
}

// Mengambil data barang berdasarkan kode yang dipindai
// function getBarangById(id) {
//     $.ajax({
//         type: 'GET',
//         url: '/barang/getById/' + id, // Ganti dengan URL API yang sesuai
//         dataType: 'json',
//         success: function(data) {
//             if (data) {
//                 // Mengisi data barang yang ditemukan ke form
//                 $('#nmbarang').val(data.nama_barang);
//                 $('#satuan').val(data.satuan);
//                 $('#jenis').val(data.jenis);
//             } else {
//                 alert('Barang tidak ditemukan');
//             }
//         },
//         error: function() {
//             alert('Terjadi kesalahan saat mengambil data barang');
//         }
//     });
// }


// Fungsi untuk menyimpan data barang masuk
function saveData() {
    const kodeBarang = $('#kdbarang').val();
    const namaBarang = $('#nmbarang').val();
    const jumlahMasuk = $('#jml').val();

    if (!kodeBarang || !namaBarang || !jumlahMasuk) {
        alert('Semua data harus diisi');
        return;
    }

    // Lakukan request ke server untuk menyimpan data
    $.ajax({
        type: 'POST',
        url: '/barangMasuk', // Ganti dengan URL API yang sesuai
        data: {
            kode_barang: kodeBarang,
            nama_barang: namaBarang,
            jumlah_masuk: jumlahMasuk
        },
        success: function(response) {
            alert('Data berhasil disimpan');
            // Tutup modal
            $('#modaldemo8').modal('hide');
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data');
        }
    });
}

// Clean up saat modal ditutup
$('#modaldemo8').on('hidden.bs.modal', function () {
    stopScanning();
});

    // Form validation
    function checkForm() {
        const tglmasuk = $("input[name='tglmasuk']").val();
        const status = $("#status").val();
        const pengecek = $("select[name='pengecek']").val();
        const jml = $("input[name='jml']").val();
        setLoading(true);
        resetValid();

        if (tglmasuk == "") {
            validasi('Tanggal Masuk wajib di isi!', 'warning');
            $("input[name='tglmasuk']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (pengecek == "") {
            validasi('Pengecek wajib di pilih!', 'warning');
            $("select[name='pengecek']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (status == "false") {
            validasi('Barang wajib di pilih!', 'warning');
            $("input[name='kdbarang']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (jml == "" || jml == "0") {
            validasi('Jumlah Masuk wajib di isi!', 'warning');
            $("input[name='jml']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else {
            submitForm();
        }
    }

    // Submit form
    function submitForm() {
        const bmkode = $("input[name='bmkode']").val();
        const tglmasuk = $("input[name='tglmasuk']").val();
        const kdbarang = $("input[name='kdbarang']").val();
        const pengecek = $("select[name='pengecek']").val();
        const jml = $("input[name='jml']").val();

        $.ajax({
            type: 'POST',
            url: "{{ route('barang-masuk.store') }}",
            enctype: 'multipart/form-data',
            data: {
                bmkode: bmkode,
                tglmasuk: tglmasuk,
                barang: kdbarang,
                pengecek: pengecek,
                jml: jml
            },
            success: function(data) {
                $('#modaldemo8').modal('toggle');
                swal({
                    title: "Berhasil ditambah!",
                    type: "success"
                });
                table.ajax.reload(null, false);
                reset();
            }
        });
    }

    // Reset form validation
    function resetValid() {
        $("input[name='tglmasuk']").removeClass('is-invalid');
        $("input[name='kdbarang']").removeClass('is-invalid');
        $("select[name='pengecek']").removeClass('is-invalid');
        $("input[name='jml']").removeClass('is-invalid');
    }

    // Reset form
    function reset() {
        resetValid();
        $("input[name='bmkode']").val('');
        $("input[name='tglmasuk']").val('');
        $("input[name='kdbarang']").val('');
        $("select[name='pengecek']").val('');
        $("input[name='jml']").val('0');
        $("#nmbarang").val('');
        $("#satuan").val('');
        $("#jenis").val('');
        $("#status").val('false');
        setLoading(false);
        stopScanning();
    }

    // Toggle loading state
    function setLoading(bool) {
        if (bool) {
            $("#btnLoader").removeClass('d-none');
            $("#btnSimpan").addClass('d-none');
        } else {
            $("#btnLoader").addClass('d-none');
            $("#btnSimpan").removeClass('d-none');
        }
    }
</script>
@endsection