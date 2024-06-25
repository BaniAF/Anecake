@extends('layout.app')
@section('title')
    Transaksi | Anecake
@endsection
@section('content')
    <div class="page-wrapper">
        <a href="{{ route('admin.transaksi.add') }}" class="btn btn-primary text-teal-50">
            <x-tabler-plus class="size-5" />
            <span>Tambah Transaksi</span>
        </a>
        <div class="table-wrapper">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-1 w-2">No</th>
                        <th class="px-2 w-72">Nama Transaksi</th>
                        <th class="px-1 w-48">Jumlah</th>
                        <th class="px-1 w-48">Status</th>
                        <th class="px-1 w-40">Total</th>
                        <th class="px-1 w-auto">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTransaksi as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $item['id'] }}
                            </td>
                            <td class="text-center">{{ $item['jumlah'] }}</td>
                            <td class="text-center badge badge-ghost">{{ $item['status'] }}</td>
                            <td class="text-center">Rp {{ number_format($item['total'], 0, ',', '.') }} </td>
                            <td class="flex p-2 justify-center">
                                <a href="#" class="btn btn-info  mr-3">
                                    <span>Detail</span>
                                </a>
                                <a href="#" class="mr-3 btn btn-warning">
                                    <span>Edit</span>
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <span>Delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
