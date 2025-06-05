@extends('templates.header')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('user.create') }}" class="btn btn-primary btn-icon-split" style="text-decoration: none;">
            <span class="icon text-white-50">
                <i class="fa fa-plus"></i>
            </span>
            <span class="text">Tambah user</span>
        </a>
    </div>
    <div class="card-body">
        @include('templates.feedback')
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>username</th>
                        <th>role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->role }}</td>
                        <td>
                            <a href="{{ route('user.edit', $row->id_user) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('user.destroy', $row->id_user) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection