@extends('templates/header')

@section('content')
<section class="content-header mb-4">
    <h1 class="h3 mb-2 text-gray-800">Kasir <small class="text-muted">Minimarket</small></h1>

</section>

<!-- Main Content -->
<div class="container-fluid">
    @include('templates/feedback')
    <!-- Tombol Scan Barcode -->


    <div class="row">
        <!-- Produk List -->
        <div class="col-lg-8 mb-4">
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#scanBarcodeModal">Scan Barcode</button>
            <form id="formScanFisik" action="{{ route('barcode.search') }}" method="POST">
                @csrf
                <input type="text" name="sku" id="barcodeInput" class="form-control" placeholder="Scan barcode di sini" style="width: 300px;">
            </form>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
                </div>
                <div class="card-body">
                    @foreach($result->chunk(4) as $chunk)
                    <div class="row">
                        @foreach($chunk as $products)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset('upload/' . $products->foto) }}" alt="Produk" class="img-fluid img-thumbnail" style="max-height:150px;">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $products->nama_produk }}</h5>
                                    <p><strong>Rp {{ number_format($products->harga, 0, ',', '.') }}</strong></p>
                                    <td>{{ $products->kategori->nama_kategori ?? '-' }}</td>
                                    @if($products->stok <= 0)
                                        <button class="btn btn-secondary btn-sm" disabled>Sold Out</button>
                                        @else
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_produk" value="{{ $products->id_produk }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                        </form>
                                        @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>




        <!-- modal scan -->


        <!-- Modal Scanner -->
        <div class="modal fade" id="scanBarcodeModal" tabindex="-1" role="dialog" aria-labelledby="scanBarcodeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Scan Barcode Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div id="reader" style="width: 100%;"></div>
                    </div>
                    <!-- Tombol Upload Gambar Barcode -->
                    <label for="barcodeImageInput" class="btn btn-info mb-3">Upload Gambar Barcode</label>
                    <input type="file" id="barcodeImageInput" accept="image/*" class="d-none">
                    <canvas id="barcodeCanvas" style="display:none;"></canvas>

                </div>
            </div>
        </div>

        <!-- Ringkasan Transaksi -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Umum</h6>

                    </div>
                </div>
                <div class="card-body">
                    @php $keranjang = session('keranjang', []); @endphp
                    @foreach($keranjang as $id => $item)
                    <div class="mb-3">
                        <strong>{{ $item['nama_produk'] }}</strong><br>
                        <small>Rp {{ number_format($item['harga'], 0, ',', '.') }} | Stok: {{ $item['stok'] }}</small>
                        <div class="d-flex align-items-center mt-2">
                            <form action="{{ route('cart.min',$id) }}" method="POST">

                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">-</button>
                            </form>
                            <input type="text" class="form-control form-control-sm text-center mx-1 jumlah-input"
                                data-harga="{{ $item['harga'] }}"
                                value="{{ $item['jumlah'] }}"
                                style="width: 50px; margin-bottom: 15px;" readonly>

                            <form action="{{ route('cart.tambah',$id) }}" method="POST">

                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">+</button>
                            </form>
                            <div class="ml-auto"><strong>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</strong></div>
                        </div>
                        <hr>
                    </div>
                    @endforeach

                    <form action="{{ route('cart.destroy') }}" method="POST" onsubmit="return confirm('Yakin hapus semua keranjang?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mb-3">Hapus Semua</button>
                    </form>

                </div>
                <div class="card-footer">
                    <form id="payment-form" action="{{ route('cart.checkout') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Total yang Harus Dibayar</label>
                            <input type="text" id="total_display" class="form-control" readonly>
                            <input type="hidden" id="total" name="total">
                        </div>

                        <div class="form-group">
                            <label>Uang Diberikan</label>
                            <input type="text" id="uang_diberikan" class="form-control" placeholder="Masukkan jumlah uang">
                            <input type="hidden" name="uang_diberikan" id="uang_diberikan_raw">



                        </div>

                        <div class="form-group">
                            <label>Kembalian</label>
                            <input type="text" id="kembalian" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Bayar Sekarang</button>
                    </form>
                </div>

                <!-- SweetAlert2 CDN -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="https://unpkg.com/html5-qrcode"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

                <!-- <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const barcodeInput = document.getElementById('barcodeInput');

                        // Fokus otomatis supaya bisa langsung scan
                        barcodeInput.focus();

                        // Submit saat Enter ditekan (scanner kirim Enter)
                        barcodeInput.addEventListener('keypress', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault(); // cegah reload
                                document.getElementById('formScanFisik').submit();
                            }
                        });

                        // Jaga-jaga kalau user klik di tempat lain
                        document.addEventListener('click', function() {
                            barcodeInput.focus();
                        });
                    });
                </script> -->

            
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==================== Barcode Scanner Section ====================
        const barcodeInput = document.getElementById('barcodeInput');
        const formScanFisik = document.getElementById('formScanFisik');
        let html5QrCode = null;

        // Scanner Configuration
        const scannerConfig = {
            fps: 10,
            qrbox: 250,
            formatsToSupport: [
                Html5QrcodeSupportedFormats.EAN_13,
                Html5QrcodeSupportedFormats.CODE_128,
                Html5QrcodeSupportedFormats.UPC_A
            ]
        };

        // Initialize Scanner Modal
        $('#scanBarcodeModal').on('shown.bs.modal', function() {
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    html5QrCode = new Html5Qrcode("reader");
                    html5QrCode.start(
                        devices[0].id,
                        scannerConfig,
                        onScanSuccess,
                        onScanError
                    ).catch(console.error);
                }
            });
        });

        // Cleanup Scanner on Modal Close
        $('#scanBarcodeModal').on('hidden.bs.modal', function() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    html5QrCode = null;
                });
            }
        });

        // Handle Image Upload
        document.getElementById('barcodeImageInput').addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            try {
                const result = await Html5Qrcode.scanFile(file, scannerConfig);
                handleBarcodeResult(result);
            } catch (err) {
                showError('Gagal membaca barcode dari gambar');
            }
        });

        // Core Scanner Functions
        function onScanSuccess(decodedText) {
            handleBarcodeResult(decodedText);
            $('#scanBarcodeModal').modal('hide');
        }

        function onScanError(errorMessage) {
            // Optional: Add error logging
        }

        function handleBarcodeResult(barcode) {
            barcodeInput.value = barcode;
            formScanFisik.dispatchEvent(new Event('submit'));
        }

        // ==================== Form Handling Section ====================
        formScanFisik.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data?.success) {
                    window.location.reload();
                } else if (data?.error) {
                    showError(data.error);
                }
            })
            .catch(error => {
                showError('Terjadi kesalahan sistem');
                console.error('Error:', error);
            });
        });

    });
</script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputUang = document.getElementById('uang_diberikan');
                        const inputUangRaw = document.getElementById('uang_diberikan_raw');
                        const inputKembalian = document.getElementById('kembalian');
                        const inputTotal = document.getElementById('total');
                        const inputTotalDisplay = document.getElementById('total_display');
                        const formPembayaran = document.getElementById('payment-form');

                        // Helper: Format Rupiah
                        function formatRupiah(angka, prefix = 'Rp ') {
                            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                                split = number_string.split(','),
                                sisa = split[0].length % 3,
                                rupiah = split[0].substr(0, sisa),
                                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                            if (ribuan) {
                                let separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }

                            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                            return prefix + rupiah;
                        }

                        // Helper: Parse Rupiah
                        function parseRupiah(rupiahString) {
                            return parseInt(rupiahString.replace(/[^0-9]/g, '')) || 0;
                        }

                        // Hitung total belanja
                        function hitungTotal() {
                            let total = 0;
                            document.querySelectorAll('.jumlah-input').forEach(input => {
                                const harga = parseInt(input.dataset.harga);
                                const jumlah = parseInt(input.value);
                                total += harga * jumlah;
                            });

                            inputTotal.value = total;
                            inputTotalDisplay.value = formatRupiah(total);
                            return total;
                        }

                        // Hitung kembalian berdasarkan input uang
                        function hitungKembalian() {
                            const total = hitungTotal();
                            const uang = parseRupiah(inputUang.value);
                            const kembalian = uang - total;

                            inputKembalian.value = (kembalian >= 0) ?
                                formatRupiah(kembalian) :
                                'Uang tidak cukup';

                            inputUangRaw.value = uang;
                        }

                        // Format input saat user mengetik
                        inputUang.addEventListener('keyup', function() {
                            this.value = formatRupiah(this.value);
                            hitungKembalian();
                        });

                        // Validasi sebelum submit
                        formPembayaran.addEventListener('submit', function(e) {
                            const total = parseInt(inputTotal.value);
                            const uang = parseRupiah(inputUang.value);

                            if (uang < total) {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Uang tidak cukup!'
                                });
                            }
                        });

                        // Inisialisasi awal
                        hitungTotal();
                    });
                </script>





            </div>
        </div>
    </div>
</div>
@endsection

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery (wajib sebelum Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (dibutuhkan untuk dropdown dan modal) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>