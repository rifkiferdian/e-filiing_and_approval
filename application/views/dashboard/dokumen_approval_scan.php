<style>
    .scan-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 16px;
        align-items: start;
    }

    .scanner-box {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #111827;
        min-height: 420px;
        overflow: hidden;
    }

    #qr-reader {
        width: 100%;
        min-height: 420px;
        color: #fff;
    }

    #qr-reader video {
        object-fit: cover;
    }

    .scan-result-box {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f8fafc;
        padding: 14px;
    }

    .scan-result-value {
        min-height: 52px;
        overflow-wrap: anywhere;
        color: #111827;
    }

    @media (max-width: 991.98px) {
        .scan-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Scan QR Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Scan QR Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="scan-layout">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Scanner Kamera</h3>
                    </div>
                    <div class="card-body">
                        <div class="scanner-box">
                            <div id="qr-reader"></div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-success" id="btn-start-scan">
                                <i class="fas fa-camera mr-1"></i> Mulai Scan
                            </button>
                            <button type="button" class="btn btn-outline-danger" id="btn-stop-scan" disabled>
                                <i class="fas fa-stop mr-1"></i> Stop
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Hasil Scan</h3>
                    </div>
                    <div class="card-body">
                        <div class="scan-result-box mb-3">
                            <strong>Isi QR</strong>
                            <div class="scan-result-value mt-2" id="scan-result">Belum ada QR discan.</div>
                        </div>

                        <button type="button" class="btn btn-primary btn-block mb-2" id="btn-open-result" disabled>
                            <i class="fas fa-external-link-alt mr-1"></i> Buka Verifikasi
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-block mb-3" id="btn-copy-result" disabled>
                            <i class="fas fa-copy mr-1"></i> Copy Hasil
                        </button>

                        <hr>

                        <label for="manual-qr">Input Manual Link / Token QR</label>
                        <textarea id="manual-qr" class="form-control" rows="4" placeholder="Tempel hasil scan QR atau token verifikasi"></textarea>
                        <button type="button" class="btn btn-warning btn-block mt-2" id="btn-use-manual">
                            <i class="fas fa-search mr-1"></i> Cek Manual
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    var html5QrCode = null;
    var lastScanResult = '';
    var verificationBaseUrl = '<?= base_url('dashboard/verifikasi_doc_approval/') ?>';

    $('#btn-start-scan').on('click', function() {
        start_scan();
    });

    $('#btn-stop-scan').on('click', function() {
        stop_scan();
    });

    $('#btn-open-result').on('click', function() {
        var url = normalize_scan_result(lastScanResult);
        if (url) {
            window.open(url, '_blank');
        }
    });

    $('#btn-copy-result').on('click', function() {
        if (!lastScanResult) {
            return;
        }

        if (navigator.clipboard) {
            navigator.clipboard.writeText(lastScanResult);
        }
        show_scan_message('success', 'Hasil scan disalin.');
    });

    $('#btn-use-manual').on('click', function() {
        var value = $.trim($('#manual-qr').val());
        if (!value) {
            show_scan_message('warning', 'Isi link atau token QR terlebih dahulu.');
            return;
        }
        set_scan_result(value);
        window.open(normalize_scan_result(value), '_blank');
    });

    function start_scan() {
        if (typeof Html5Qrcode === 'undefined') {
            show_scan_message('danger', 'Library scanner gagal dimuat. Periksa koneksi internet atau gunakan input manual.');
            return;
        }

        if (html5QrCode) {
            return;
        }

        html5QrCode = new Html5Qrcode('qr-reader');
        Html5Qrcode.getCameras().then(function(cameras) {
            if (!cameras || cameras.length === 0) {
                show_scan_message('warning', 'Kamera tidak ditemukan. Gunakan input manual.');
                html5QrCode = null;
                return;
            }

            var cameraId = cameras.length > 1 ? cameras[cameras.length - 1].id : cameras[0].id;
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: {
                        width: 260,
                        height: 260
                    }
                },
                function(decodedText) {
                    set_scan_result(decodedText);
                    stop_scan();
                },
                function() {}
            ).then(function() {
                $('#btn-start-scan').prop('disabled', true);
                $('#btn-stop-scan').prop('disabled', false);
            }).catch(function(error) {
                html5QrCode = null;
                show_scan_message('danger', 'Kamera tidak bisa dibuka: ' + error);
            });
        }).catch(function(error) {
            html5QrCode = null;
            show_scan_message('danger', 'Akses kamera gagal: ' + error);
        });
    }

    function stop_scan() {
        if (!html5QrCode) {
            return;
        }

        html5QrCode.stop().then(function() {
            html5QrCode.clear();
            html5QrCode = null;
            $('#btn-start-scan').prop('disabled', false);
            $('#btn-stop-scan').prop('disabled', true);
        }).catch(function() {
            html5QrCode = null;
            $('#btn-start-scan').prop('disabled', false);
            $('#btn-stop-scan').prop('disabled', true);
        });
    }

    function set_scan_result(value) {
        lastScanResult = value;
        $('#scan-result').text(value);
        $('#btn-open-result, #btn-copy-result').prop('disabled', false);
        show_scan_message('success', 'QR berhasil discan.');
    }

    function normalize_scan_result(value) {
        value = $.trim(value || '');
        if (!value) {
            return '';
        }

        if (/^https?:\/\//i.test(value)) {
            return value;
        }

        var tokenMatch = value.match(/verifikasi_doc_approval\/([A-Za-z0-9]+)/);
        if (tokenMatch && tokenMatch[1]) {
            return verificationBaseUrl + encodeURIComponent(tokenMatch[1]);
        }

        return verificationBaseUrl + encodeURIComponent(value);
    }

    function show_scan_message(type, message) {
        $(document).Toasts('create', {
            class: 'bg-' + type,
            title: 'Scan QR Approval',
            body: message,
            autohide: true,
            delay: 3500
        });
    }
</script>
