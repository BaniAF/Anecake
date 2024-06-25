@extends('layout.app')
@section('title')
    Kategori | Anecake
@endsection
@section('content')
@include('sweetalert::alert')
    <div class="page-wrapper">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    <div class="px-2 py-2 flex ">
                        <h1 class="text-2xl font-bold"> Tambah Kategori</h1>
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
                    <button type="submit" class="btn btn-primary text-white">Simpan</button>
                </form>

            </div>
        </div>
        <div class="table-wrapper">
            <table id="myTable" class="display" style="width:100%">
                <div class="px-2 py-2 flex "> 
                    <h1 class="text-2xl font-bold"> Data Kategori</h1>
                </div>
                <thead>
                    <tr>
                        <th class="px-1 w-10">No</th>
                        <th class="px-2 w-auto">Nama Kategori</th>
                        <th class="px-1 w-15">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataKategori as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $item['namaKategori'] }}</td>
                            <td class="flex p-2 justify-center">
                                <button class="btn mr-3" onclick="showModal(this)" data-id="{{ $item['id'] }}" data-nama="{{ $item['namaKategori'] }}">
                                    <span>Edit</span>
                                </button>
                                <form id="deleteForm{{ $item['id'] }}" action="{{ route('admin.kategori.hapus', $item['id']) }}" method="post">
                                    @csrf
                                    <a href="#" onclick="confirmDelete('{{ $item['id'] }}')">
                                        <x-tabler-trash class="size-5"/>
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <h3 class="font-bold text-lg" style="text-align: end">Edit Kategori</h3>
                <form id="editForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="id" id="modal-id">
                    <div class="py-4">
                        <label for="namaKategori">Nama Kategori</label>
                        <input type="text" name="editKategori" id="modal-namaKategori" class="input input-bordered w-full">
                    </div>
                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary text-white">Save</button>
                        <button type="button" class="btn" onclick="closeModal()">Close</button>
                    </div> 
                </form>
            </div>
        </dialog>
    </div>

    <script>
         function showModal(button) {
            var itemId = button.getAttribute('data-id');
            var itemName = button.getAttribute('data-nama');
            var modal = document.getElementById('my_modal_5');
            var modalId = document.getElementById('modal-id');
            var modalNamaKategori = document.getElementById('modal-namaKategori');
            var editForm = document.getElementById('editForm');

            // Set the form values
            modalId.value = itemId;
            modalNamaKategori.value = itemName;
            editForm.action = "{{ url('/kategori-update') }}/" + itemId;

            // Show the modal
            modal.showModal();
        }

        function closeModal() {
            var modal = document.getElementById('my_modal_5');
            modal.close();
        }
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
