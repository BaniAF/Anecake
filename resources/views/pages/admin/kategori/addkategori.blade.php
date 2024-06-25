@extends('layout.app')
@section('title')
    Kategori | Anecake
@endsection
@section('content')
    <div class="page-wrapper">
        <h1>ini Halaman Tambah Kategori</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    <div class="px-2 py-2 flex bg-primary rounded-sm ">
                        <x-tabler-plus class="size-5"/>
                        <h1>Tambah Kategori</h1>
                    </div>
                    @csrf
                    <div class="form-group">
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Nama Kategori</span>
                            </div>
                            <input type="text" placeholder="masukkan nama kategori" class="input input-bordered w-full max-w-xs" name="namaKategori" />
                            <div class="label">
                            </div>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

            </div>
        </div>
    </div>
@endsection
