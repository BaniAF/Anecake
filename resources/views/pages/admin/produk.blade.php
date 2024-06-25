@extends('layout.app')
@section('title')
    Produk | Anecake
@endsection
@section('content')
@include('sweetalert::alert')
    <div class="page-wrapper">
        <a href="{{ route('admin.produk.add') }}" class="btn btn-primary text-teal-50">
            <x-tabler-plus class="size-5" />
            <span>Tambah Produk</span>
        </a>
        <div class="table-wrapper">
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="" style="text-align: center">No</th style="text-align: center">
                        <th class="px-2 w-72" style="text-align: center">Nama Produk</th>
                        <th class="px-1 w-48" style="text-align: center">Kategori Produk</th>
                        <th class="px-1 w-48" style="text-align: center">Harga Produk</th>
                        <th class="px-1 w-40" style="text-align: center">Stok Produk</th>
                        <th class="px-1 py-2 w-auto h-auto" style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                        <tr>
                            <td class="w-1" style="text-align: center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="flex justify-center " style="text-align: justify">
                                    <div class="avatar mr-3">
                                        <div class="w-14 h-14 rounded">
                                            <img src="{{ $item['gambar'] }}" alt="gambar produk" />
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="text-md font-extrabold">{{ $item['namaProduk'] }}</h2>
                                        <p class="text-gray-500 text-sm">{{ $item['deskripsi'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $item['namaKategori'] }}</td>
                            <td class="text-center">Rp {{ number_format($item['hargaProduk'], 0, ',', '.') }} </td>
                            <td class="text-center">{{ $item['stokProduk'] }} paket</td>
                            <td class="flex p-2 px-2 py-2 justify-center">
                                <button class="btn mr-3" onclick="showModal(this)" data-id="{{ $item['id'] }}"
                                    data-nama="{{ $item['namaProduk'] }}" data-kategori="{{ $item['idKategori'] }}"
                                    data-harga="{{ $item['hargaProduk'] }}" data-stok="{{ $item['stokProduk'] }}"
                                    data-deskripsi="{{ $item['deskripsi'] }}" data-gambar="{{ $item['gambar'] }}">
                                    <span>Edit</span>
                                </button>
                                <form id="deleteForm{{ $item['id'] }}"
                                    action="{{ route('admin.produk.destroy', $item['id']) }}" method="post">
                                    @csrf
                                    <a href="#" onclick="confirmDelete('{{ $item['id'] }}')">
                                        <x-tabler-trash class="size-5" />
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h1 class="text-2xl font-bold" style="text-align: end">Edit Produk</h1>
            <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="modal-id" name="id">
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
                        <input type="file" id="imageUpload" class="hidden input input-bordered w-full mt-2"
                            name="gambar" />
                    </label>
                </div>
                <div class="form-group mb-4 flex flex-col lg:flex-row gap-4">
                    <div class="w-full lg:w-1/2">
                        <label class="form-label block">
                            <span class="label-text font-semibold">Nama Produk</span>
                            <input type="text" id="modal-namaProduk" placeholder="Masukkan nama produk"
                                class="input input-bordered w-full mt-2" name="namaProduk" />
                        </label>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <label class="form-label block">
                            <span class="label-text font-semibold">Nama Kategori</span>
                            <select id="modal-namaKategori" class="select select-bordered w-full mt-2" name="namaKategori">
                                <option disabled selected>Pilih Kategori</option>
                                @foreach ($dataKategori as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['namaKategori'] }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <div class="form-group mb-4 flex flex-col lg:flex-row gap-4">
                    <div class="w-full lg:w-1/2">
                        <label class="form-label block">
                            <span class="label-text font-semibold">Harga Produk</span>
                            <input type="number" id="modal-hargaProduk" placeholder="Masukkan harga produk"
                                class="input input-bordered w-full mt-2" name="hargaProduk" />
                        </label>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <label class="form-label block">
                            <span class="label-text font-semibold">Stok Produk</span>
                            <input type="number" id="modal-stokProduk" placeholder="Masukkan stok produk"
                                class="input input-bordered w-full mt-2" name="stokProduk" />
                        </label>
                    </div>
                </div>
                <div class="form-group mb-6">
                    <label class="form-label block">
                        <span class="label-text font-semibold">Deskripsi Produk</span>
                        <textarea id="modal-deskripsi" class="textarea textarea-bordered w-full mt-2" placeholder="Deskripsi produk"
                            name="deskripsi"></textarea>
                    </label>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary text-white">Simpan</button>
                    <button type="button" class="btn" onclick="closeModal()">Kembali</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function showModal(button) {
            var modal = document.getElementById('my_modal_5');
            var modalId = document.getElementById('modal-id');
            var modalNamaProduk = document.getElementById('modal-namaProduk');
            var modalNamaKategori = document.getElementById('modal-namaKategori');
            var modalHargaProduk = document.getElementById('modal-hargaProduk');
            var modalStokProduk = document.getElementById('modal-stokProduk');
            var modalDeskripsi = document.getElementById('modal-deskripsi');
            var modalImagePreview = document.getElementById('imagePreview');
            var editForm = document.getElementById('editForm');

            // Set form values
            modalId.value = button.getAttribute('data-id');]
            modalNamaProduk.value = button.getAttribute('data-nama');
            modalNamaKategori.value = button.getAttribute('data-kategori');
            modalHargaProduk.value = button.getAttribute('data-harga');
            modalStokProduk.value = button.getAttribute('data-stok');
            modalDeskripsi.value = button.getAttribute('data-deskripsi');
            modalImagePreview.src = button.getAttribute('data-gambar');
            editForm.action = "{{ url('/produk-update') }}/" + button.getAttribute('data-id');

            // Show the modal
            modal.showModal();
        }

        function closeModal() {
            var modal = document.getElementById('my_modal_5');
            modal.close();
        }

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
    <script>
        function confirmDelete(kode) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Data akan terhapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if the user clicks "Yes, delete it!"
                    document.getElementById('deleteForm' + kode).submit();
                }
            });
        }
    </script>
@endsection
