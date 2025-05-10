<!-- Begin Page Content -->
@extends('templates.header')
@section('content')


<div class="container-fluid">

       <!-- Page Heading -->
       <h1 class="h3 mb-4 text-gray-800">Tambah Kategori</h1>

       <div class="card shadow mb-mp4">
       @include('templates.feedback')
              <div class="card-header py-3">
                     <h6>Data Tamu</h6>
              </div>
              <div class="card-body">
              <form method="post" action="{{ isset($result) && $result ? route('produk.update', $result->id_produk) : url('produk/add') }}" enctype="multipart/form-data">


                            @csrf
                            @if (!empty($result)) @method('PUT')

                            @endif
                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Nama Produk</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="nama_produk" class="form-control">
                                   </div>
                            </div>
                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Stok</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="stok" class="form-control">
                                   </div>
                            </div>
                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Harga</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="harga" class="form-control">
                                   </div>
                            </div>
                            <div class="form-group row">
                            <label for="id_kategori">Kelas</label>
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
                            <label class="control-label col-sm-2">Foto</label>
                            <div class="col-sm-10">
                                   <input type="file" name="foto"/>
                            </div>
                        </div>

                            <div class="form-group row">
                                   <div class="col-sm-8 offset-sm-3 d-flex justify-content-end">
                                          <div>
                                                 <a type="button" class="btn btn-danger btn-icon-split" href="{{ url('kategori') }}">
                                                        <span class="icon text-white-50">
                                                               <i class="fas fa-chevron-left"></i>
                                                        </span>
                                                        <span class="text">Kembali</span>
                                                 </a>
                                                 <button type="submit" class="btn btn-primary">Simpan</button>
                                          </div>
                                   </div>
                            </div>
                     </form>
              </div>
       </div>

</div>
<!-- /.container-fluid -->
@endsection