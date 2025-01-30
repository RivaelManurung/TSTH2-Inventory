<!-- Add Instascan library to your page -->
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

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
    let scanner = null;

    // Start barcode scanning using Instascan
    function scanBarcode() {
        $('#interactive').show();

        if (!scanner) { // Hindari inisialisasi ulang jika scanner sudah ada
            scanner = new Instascan.Scanner({ video: document.querySelector('#interactive video') });

            scanner.addListener('scan', function (decodedText) {
                $('input[name="kdbarang"]').val(decodedText);
                getbarangbyid(decodedText);
                stopScanning(); // Stop scanner setelah scan berhasil
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]); // Gunakan kamera pertama
                } else {
                    console.error("No cameras found.");
                    alert("No cameras found.");
                }
            }).catch(function (err) {
                console.error("Error accessing cameras:", err);
                alert("Error accessing cameras: " + err);
            });
        }
    }

    // Stop scanner function
    function stopScanning() {
        if (scanner) {
            scanner.stop();
            scanner = null;
        }
        $('#interactive').hide();
    }

    // Clean up scanner when modal is closed
    $('#modaldemo8').on('hidden.bs.modal', stopScanning);

    // Reset form function
    function reset() {
        resetValid();
        $("input[name='bmkode'], input[name='tglmasuk'], input[name='kdbarang'], #nmbarang, #satuan, #jenis").val('');
        $("select[name='pengecek']").val('');
        $("input[name='jml']").val('0');
        $("#status").val('false');
        setLoading(false);
        stopScanning();
    }

    // Handle keypress on Kode Barang field (Enter key)
    $('input[name="kdbarang"]').keypress(function(event) {
        if (event.which === 13) { // Keycode 13 = Enter
            getbarangbyid($(this).val());
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

    // Fetch Barang Data by ID
    async function getbarangbyid(id) {
        console.log("Fetching barang with ID:", id);
        $("#loaderkd").removeClass('d-none');

        try {
            let response = await $.ajax({
                type: 'GET',
                url: `{{ url('admin/barang/getbarang') }}/${id}`,
                dataType: 'json'
            });

            console.log("Response from server:", response);
            $("#loaderkd").addClass('d-none');

            if (response && response.length > 0) {
                let barang = response[0];
                console.log("Barang data:", barang);
                $("#status").val("true");
                $("#nmbarang").val(barang.barang_nama || '');
                $("#satuan").val(barang.satuan_nama || '');
                $("#jenis").val(barang.jenisbarang_nama || '');
            } else {
                $("#status").val("false");
                $("#nmbarang, #satuan, #jenis").val('');
                validasi('Barang tidak ditemukan!', 'warning');
            }
        } catch (error) {
            console.error("Error fetching barang:", error);
            $("#loaderkd").addClass('d-none');
            validasi('Terjadi kesalahan saat mengambil data barang.', 'error');
        }
    }

    // Form Validation
    function checkForm() {
        const tglmasuk = $("input[name='tglmasuk']").val();
        const status = $("#status").val();
        const pengecek = $("select[name='pengecek']").val();
        const jml = $("input[name='jml']").val();

        setLoading(true);
        resetValid();

        if (!tglmasuk) {
            validasi('Tanggal Masuk wajib di isi!', 'warning');
            $("input[name='tglmasuk']").addClass('is-invalid');
        } else if (!pengecek) {
            validasi('Pengecek wajib di pilih!', 'warning');
            $("select[name='pengecek']").addClass('is-invalid');
        } else if (status === "false") {
            validasi('Barang wajib di pilih!', 'warning');
            $("input[name='kdbarang']").addClass('is-invalid');
        } else if (!jml || jml === "0") {
            validasi('Jumlah Masuk wajib di isi!', 'warning');
            $("input[name='jml']").addClass('is-invalid');
        } else {
            submitForm();
            return;
        }
        setLoading(false);
    }

    // Submit Form Data
    async function submitForm() {
        const data = {
            bmkode: $("input[name='bmkode']").val(),
            tglmasuk: $("input[name='tglmasuk']").val(),
            barang: $("input[name='kdbarang']").val(),
            pengecek: $("select[name='pengecek']").val(),
            jml: $("input[name='jml']").val()
        };

        try {
            await $.ajax({
                type: 'POST',
                url: "{{ route('barang-masuk.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                enctype: 'multipart/form-data'
            });

            $('#modaldemo8').modal('toggle');
            swal({ title: "Berhasil ditambah!", type: "success" });
            table.ajax.reload(null, false);
            reset();
        } catch (error) {
            console.error("Error submitting form:", error);
            validasi('Gagal menyimpan data!', 'error');
        }
    }

    // Reset form validation
    function resetValid() {
        $("input, select").removeClass('is-invalid');
    }

    // Toggle loading state
    function setLoading(state) {
        $("#btnLoader").toggleClass('d-none', !state);
        $("#btnSimpan").toggleClass('d-none', state);
    }
</script>
@endsection
