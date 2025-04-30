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
                     <form method="post" action="{{ !empty($result) ? url('kategori/'.$result->id_kategori.'/edit') : url('kategori/add') }}">
                            @csrf
                            @if (!empty($result)) @method('PUT')

                            @endif
                            <div class="form-group row">
                                   <label class="col-sm-3 col-form-label">Nama Kategori</label>
                                   <div class="col-sm-8">
                                          <input type="text" name="nama_kategori" class="form-control">
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