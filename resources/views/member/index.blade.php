@extends('templates.header')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('member.create') }}" class="btn btn-primary btn-icon-split" style="text-decoration: none;">
            <span class="icon text-white-50">
                <i class="fa fa-plus"></i>
            </span>
            <span class="text">Tambah Member</span>
        </a>
    </div>
    <div class="card-body">
        @include('templates.feedback')
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Member</th>
                        <th>No Hp</th>
                        <th>status Member</th>
                        <th>Tanggal daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->no_hp }}</td>
                        <td>{{ $row->status_member ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $row->tanggal_daftar->format('d/m/Y') }}</td>
                        <td>
                            <!-- PERBAIKAN: Gunakan $row->id_customers -->
                            <a href="{{ route('member.edit', $row->id_customers) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('member.destroy', $row->id_customers) }}" method="POST" style="display:inline">
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