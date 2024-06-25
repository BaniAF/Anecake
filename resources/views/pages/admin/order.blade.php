@extends('layout.app')
@section('title')
    Order | Anecake
@endsection
@section('content')
    <div class="page-wrapper">
        <h1>ini Halaman Order</h1>
        <div class="table-wrapper">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-1 w-2">No</th>
                        <th class="px-2 w-72">Nama Order</th>
                        <th class="px-1 w-48">Jumlah</th>
                        <th class="px-1 w-48">Total</th>
                        <th class="px-1 w-40">Status</th>
                        <th class="px-1 w-auto">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataOrder as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $item['id'] }}
                            </td>
                            <td class="text-center">{{ $item['jumlah'] }}</td>
                            <td class="text-center">Rp {{ number_format($item['total'], 0, ',', '.') }} </td>
                            <td class="text-center">{{ $item['status'] }}</td>
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
