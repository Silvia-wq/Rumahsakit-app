@extends('layout.admin')

@section('title', 'Poliklinik')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Poliklinik</h1>

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('poliklinik.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
   
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Poliklinik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($poliklinik as $poli)
                        <tr>
                            <td>{{ $poli->id }}</td>
                            <td>{{ $poli->nama_poliklinik }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('poliklinik.edit', $poli->id) }}" class="btn btn-warning">Edit</a>

                                <!-- Tombol Delete -->
                                <form action="{{ route('poliklinik.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @include('sweetalert::alert')
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Sertakan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sertakan file JavaScript khusus -->
<script src="{{ asset('js/sweetalert.js') }}"></script>

@endsection