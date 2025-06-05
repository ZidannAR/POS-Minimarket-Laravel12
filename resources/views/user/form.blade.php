@extends('templates.header')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">{{ isset($result) ? 'Edit' : 'Tambah' }} User</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ isset($result) ? route('user.update', $result) : route('user.store') }}">
                @csrf
                @if(isset($result)) @method('PUT') @endif
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="username" class="form-control" value="{{ $result->username ?? old('username') }}" required>
                </div>
                
                <div class="form-group">
                    <label>email</label>
                    <input type="text" name="email" class="form-control" value="{{ $result->email ?? old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>password</label>
                    <input type="text" name="password" class="form-control" value="{{ $result->password ?? old('role') }}" required>
                </div>
                <div class="form-group">
                    <label for="role" class="control-label col-sm-2">Role</label>
                    <div class="col-sm-10">
                        <select name="role" id="role" class="form-control">
                            <option value="admin" {{ old('role', $result->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('role', $result->role ?? '') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                    </div>
                </div>
               
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection