<!-- Begin Page Content -->
@extends('templates.header')
@section('content')

<div class="container-fluid">
       <!-- Page Heading -->
       <h1 class="h3 mb-4 text-gray-800">Tambah Produk</h1>

       <div class="card shadow mb-mp4">
              @include('templates.feedback')
              <div class="card-header py-3">
                     <h6>data produk</h6>
              </div>
              <div class="card-body">
                     <form method="post" action="{{ isset($result) && $result ? route('produk.update', $result->id_produk) : url('produk/add') }}" enctype="multipart/form-data">

                            @csrf
                            @if (!empty($result)) @method('PUT') @endif

                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Nama Produk</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="nama_produk" class="form-control" value="{{ $result->nama_produk ?? old('nama_produk') }}">
                                   </div>
                            </div>

                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Stok</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="stok" class="form-control" value="{{ $result->stok ?? old('stok') }}">
                                   </div>
                            </div>

                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Harga</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="harga_display" id="harga" class="form-control" autocomplete="off" value="{{ isset($result->harga) ? number_format($result->harga, 0, ',', '.') : old('harga') }}"
                                                 placeholder="Masukkan Harga Produk">
                                          <input type="hidden" name="harga" id="harga_raw">
                                   </div>
                            </div>

                            <div class="form-group row">
                                   <label for="id_kategori">kategori</label>
                                   <select class="form-control" id="id_kategori" name="id_kategori">
                                          @foreach(\App\Models\kategori::all() as $kategori)
                                          <option value="{{ $kategori->id_kategori }}"
                                                 {{ (!empty($result) && $result->id_kategori == $kategori->id_kategori) || old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                                 {{ $kategori->nama_kategori }}
                                          </option>
                                          @endforeach
                                   </select>
                            </div>

                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">SKU / Barcode</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="sku" id="sku" class="form-control" placeholder="Masukkan Sku" autocomplete="off"
                                                 value="{{ isset($result->sku) ? $result->sku : '' }}">

                                          <!-- Tombol untuk membuka modal -->
                                          <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#barcodeModal">
                                                 Scan Barcode
                                          </button>
                                   </div>
                            </div>

                            <div class="form-group row">
                                   <label class="control-label col-sm-2">Foto</label>
                                   <div class="col-sm-10">
                                          <input type="file" name="foto" value="{{ $result->foto ?? old('foto') }}" />
                                   </div>
                            </div>

                            <div class="form-group row">
                                   <div class="col-sm-8 offset-sm-3 d-flex justify-content-end">
                                          <div>
                                                 <a type="button" class="btn btn-danger btn-icon-split" href="{{ url('kategori') }}">
                                                        <span class="icon text-white-50"><i class="fas fa-chevron-left"></i></span>
                                                        <span class="text">Kembali</span>
                                                 </a>
                                                 <button type="submit" class="btn btn-primary">Simpan</button>
                                          </div>
                                   </div>
                            </div>

                     </form>

                     <!-- ✅ Modal Scanner Barcode -->
                     <!-- Modal Barcode -->
                     <div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                   <div class="modal-content">
                                          <div class="modal-header">
                                                 <h5 class="modal-title" id="barcodeModalLabel">Scan Barcode Produk</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                 </button>
                                          </div>
                                          <div class="modal-body text-center">
                                                 <!-- Kamera -->
                                                 <div id="reader" style="width: 100%; max-width: 500px; margin: auto;"></div>

                                                 <!-- Upload Gambar -->
                                                 <label for="barcode-upload" class="btn btn-secondary mt-3">Upload Gambar Barcode</label>
                                                 <input type="file" id="barcode-upload" accept="image/*" style="display: none;" />
                                          </div>
                                   </div>
                            </div>
                     </div>


              </div>
       </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Scanner Library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
       // Format harga ke rupiah
       const hargaDisplay = document.getElementById('harga');
       const hargaRaw = document.getElementById('harga_raw');

       hargaDisplay.addEventListener('input', function(e) {
              let value = this.value.replace(/\D/g, '');
              if (!value) {
                     this.value = '';
                     hargaRaw.value = '';
                     return;
              }
              this.value = formatRupiah(value);
              hargaRaw.value = value;
       });

       function formatRupiah(angka) {
              let numberString = angka.toString();
              let sisa = numberString.length % 3;
              let rupiah = numberString.substr(0, sisa);
              let ribuan = numberString.substr(sisa).match(/\d{3}/g);

              if (ribuan) {
                     let separator = sisa ? '.' : '';
                     rupiah += separator + ribuan.join('.');
              }

              return 'Rp ' + rupiah;
       }

       
       let html5QrCode;

       // Aktifkan kamera saat modal dibuka
       $('#barcodeModal').on('shown.bs.modal', function() {
              if (!html5QrCode) {
                     html5QrCode = new Html5Qrcode("reader");
              }

              Html5Qrcode.getCameras().then(devices => {
                     if (devices && devices.length) {
                            html5QrCode.start({
                                          facingMode: "environment"
                                   }, {
                                          fps: 10,
                                          qrbox: 250
                                   },
                                   decodedText => {
                                          document.getElementById("sku").value = decodedText;
                                          html5QrCode.stop();
                                          $('#barcodeModal').modal('hide');
                                   },
                                   errorMessage => {
                                          // console.log(`QR error = ${errorMessage}`);
                                   }
                            );
                     }
              }).catch(err => {
                     console.error(err);
              });
       });

       // Matikan kamera saat modal ditutup
       $('#barcodeModal').on('hidden.bs.modal', function() {
              if (html5QrCode) {
                     html5QrCode.stop().then(() => {
                            html5QrCode.clear();
                     });
              }
       });

       // Upload dari file
       document.getElementById("barcode-upload").addEventListener("change", function(e) {
              const file = e.target.files[0];
              if (!file) return;

              const uploader = new Html5Qrcode("reader"); // bisa pakai yang sama
              uploader.scanFile(file, true)
                     .then(decodedText => {
                            document.getElementById("sku").value = decodedText;
                            Swal.fire({
                                   icon: 'success',
                                   title: 'horeee',
                                   text: 'Barcode berhasil dipindai:'
                                   + decodedText
                            });
                            $('#barcodeModal').modal('hide');
                     })
                     .catch(err => {
                            alert("Gagal memindai barcode dari gambar.");
                            console.error("Scan error", err);
                     });
       });
</script>

@endsection