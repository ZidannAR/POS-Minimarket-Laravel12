@extends('templates.header')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">{{ isset($member) ? 'Edit' : 'Tambah' }} Customer</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ isset($member) ? route('member.update', $member) : route('member.store') }}">
                @csrf
                @if(isset($member)) @method('PUT') @endif
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ $member->nama ?? old('nama') }}" required>
                </div>
                
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $member->no_hp ?? old('no_hp') }}" required>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="status_member" id="status_member" 
                            class="form-check-input" value="1" 
                            {{ isset($member) && $member->status_member ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_member">Status Member Aktif</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection