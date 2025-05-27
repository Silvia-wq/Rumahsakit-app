@extends(Auth::user()->roles === 'admin' ? 'layout.admin' : 
        (Auth::user()->roles === 'pasien' ? 'layout.pasien' : 
        (Auth::user()->roles === 'petugas' ? 'layout.petugas' : 'layout.default')))

@section('title', 'Edit Data User')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 text-center">
                    <label for="foto_user" class="form-label d-block"></label>
                    <!-- Preview gambar -->
                    <img id="preview-image" src="{{ Auth::user()->foto_user ? asset('storage/foto_user/' . Auth::user()->foto_user) : asset('img/default.jpg') }}" 
                         alt="Foto Profil" class="img-fluid mb-3" style="max-width: 70%; height: auto;">
                    <input type="file" name="foto_user" id="foto_user" class="form-control" accept="image/*" onchange="loadFile(event)">
                </div>

                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_user">Nama User</label>
                            <input type="text" name="nama_user" id="nama_user" class="form-control" 
                                   value="{{ old('nama_user', Auth::user()->nama_user) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="username">Email/Username</label>
                            <input type="text" name="username" id="username" class="form-control" 
                                   value="{{ old('username', Auth::user()->username) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control" 
                                   value="{{ old('no_telepon', Auth::user()->no_telepon) }}" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('dashboard-' . Auth::user()->roles) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var loadFile = function(event) {
        var output = document.getElementById('preview-image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };
</script>
@endsection
@include('sweetalert::alert')