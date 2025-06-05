@extends('templates.header')

<!-- Begin Page Content -->
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
       
    <a href="{{ url('kategori/add') }}" class="btn btn-primary btn-icon-split" style="text-decoration: none;">
    <span class="icon text-white-50">
        <i class="fa fa-plus"></i>
    </span>
    <span class="text">Kategori</span>
</a>

    </div>
    <div class="card-body">
    @yield('content')
    @include('templates.feedback')
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 800px; display: flex; justify-content: center;" >nama kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($result as $row)
                    <tr>
                        <td>{{ !empty($i) ? ++$i : $i = 1 }}</td>
                        <td>{{ $row->nama_kategori }}</td>
                        <td>
                            <form action="{{ url('kategori/' . $row->id_kategori . '/delete') }}" method="post">
                                <a class="btn btn-success" href="{{ url("kategori/$row->id_kategori/edit") }}">Ubah</a>
                                   @csrf
                                   @method('DELETE')

                                   <button type="submit"class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <!-- Tambahkan baris lain di sini jika perlu -->
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->
 
@endsection
@include('templates.footer')

