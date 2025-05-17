@extends('templates/header')

@section('content')
<section class="content-header mb-4">
    <h1 class="h3 mb-2 text-gray-800">Kasir <small class="text-muted">Minimarket</small></h1>

</section>

<!-- Main Content -->
<div class="container-fluid">
    @include('templates/feedback')

    <div class="row">
        <!-- Produk List -->
        <div class="col-lg-8 mb-4">
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
                                    <<form action="{{ route('cart.add') }}" method="POST">

                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $products->id_produk }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                        </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
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
                                style="width: 50px;" readonly>

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


              <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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

            inputKembalian.value = (kembalian >= 0)
                ? formatRupiah(kembalian)
                : 'Uang tidak cukup';

            inputUangRaw.value = uang;
        }

        // Format input saat user mengetik
        inputUang.addEventListener('keyup', function () {
            this.value = formatRupiah(this.value);
            hitungKembalian();
        });

        // Validasi sebelum submit
        formPembayaran.addEventListener('submit', function (e) {
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