@extends('layout.app')
@section('title')
    Produk | Anecake
@endsection
@section('content')
    <div class="page-wrapper p-6">
        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="px-2 py-2 flex justify-between items-center">
                        <h1 class="text-2xl font-bold">Tambah Produk</h1>
                    </div>
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label block">
                            <div class="text-center">
                                <span class="label-text font-semibold">Gambar Produk</span>
                            </div>
                            <div class="flex justify-center mt-2">
                                <div class="avatar">
                                    <div class="w-20 rounded">
                                        <img src="{{ asset('images/no-image.jpg') }}" id="imagePreview" alt="Image" />
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="imageUpload" class="hidden input input-bordered w-full mt-2" name="gambar" />
                        </label>
                    </div>
                    <div class="form-group mb-4 flex flex-col lg:flex-row gap-4">
                        <div class="w-full lg:w-1/2">
                            <label class="form-label block">
                                <span class="label-text font-semibold">Nama Produk</span>
                                <input type="text" placeholder="Masukkan nama produk" class="input input-bordered w-full mt-2" name="namaProduk" />
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label class="form-label block">
                                <span class="label-text font-semibold">Nama Kategori</span>
                                <select class="select select-bordered w-full mt-2" name="namaKategori">
                                    <option disabled selected>Pilih Kategori</option>
                                    @foreach ($dataKategori as $item)
                                        <option value="{{$item['id']}}">{{ $item['namaKategori'] }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-4 flex flex-col lg:flex-row gap-4">
                        <div class="w-full lg:w-1/2">
                            <label class="form-label block">
                                <span class="label-text font-semibold">Harga Produk</span>
                                <input type="number" placeholder="Masukkan harga produk" class="input input-bordered w-full mt-2" name="hargaProduk" />
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label class="form-label block">
                                <span class="label-text font-semibold">Stok Produk</span>
                                <input type="number" placeholder="Masukkan stok produk" class="input input-bordered w-full mt-2" name="stokProduk" />
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <label class="form-label block">
                            <span class="label-text font-semibold">Deskripsi Produk</span>
                            <textarea class="textarea textarea-bordered w-full mt-2" placeholder="Deskripsi produk" name="deskripsi"></textarea>
                        </label>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary mr-2 text-white">Simpan</button>
                        <a href="{{ route('admin.produk') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const image_input = document.querySelector("#imageUpload");
        image_input.addEventListener("change", function() {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                const uploaded_image = reader.result;
                document.querySelector("#imagePreview").src = uploaded_image;
            });
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
