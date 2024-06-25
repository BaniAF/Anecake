{{-- @extends('layout.app')
@section('title')
    Transaksi | Anecake
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
            @foreach ($produk as $item)
                <div class="card w-auto bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center">
                            <input type="checkbox" class="checkbox checkbox-primary mr-2"
                                onchange="toggleQuantity(this, '{{ $item['id'] }}')">
                            <h2 class="card-title">{{ $item['namaProduk'] }}</h2>
                        </div>
                        <p class="text-lg font-semibold text-gray-700">Rp
                            {{ number_format($item['hargaProduk'], 0, ',', '.') }}</p>
                        <div class="flex items-center mt-4">
                            <button class="btn btn-outline btn-primary"
                                onclick="changeQuantity('{{ $item['id'] }}', -1)">-</button>
                            <input type="number" id="quantity-{{ $item['id'] }}" value="0" min="0"
                                class="input input-bordered w-16 mx-2 text-center " readonly>
                            <button class="btn btn-outline btn-primary"
                                onclick="changeQuantity('{{ $item['id'] }}', 1)">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between">
                    <h1 class="text-lg">Metode Pembayaran</h1>
                    <select class="select select-bordered w-full max-w-xs">
                        <option disabled selected>Pilih Metode Bayar</option>
                        <option>Tunai</option>
                        <option>Kartu</option>
                        <option>Transfer</option>
                    </select>
                </div>
                <div class=" flex justify-between">
                    <h1 class="text-xl">Total Pembayaran</h1>
                    <h2 id="total-pembayaran" class="text-lg">Rp 0</h2>
                </div>
                <div>
                    <form action="">
                        <button class="btn btn-primary btn-block text-white" type="button"
                            onclick="showModal()">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
        <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box bg-white p-4 rounded-lg shadow-lg">
                <h3 class="font-bold text-lg text-right mb-4">Detail Pesanan</h3>
                <form id="editForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="id" id="modal-id">
                    <div class="py-4">
                        <table class="w-full ">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nama Produk</th>
                                    <th class="px-4 py-2">Kuantiti</th>
                                    <th class="px-4 py-2">Harga</th>
                                    <th class="px-4 py-2">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody id="modal-tbody">
                                <!-- Data produk akan diisi disini -->
                            </tbody>
                            <tfoot class="mt-20">
                                <tr class="bg-base-200">
                                    <td colspan="3" class="px-4 py-2 text-left  font-bold text-md">Jumlah Bayar</td>
                                    <td id="modal-total-pembayaran" class="px-4 py-2 font-bold text-md">Rp 0</td>
                                </tr>
                                <tr class="bg-base-100">
                                    <td colspan="3" class="px-4 py-2 text-left  font-bold text-md">Metode Pembayaran</td>
                                    <td id="modal-total-pembayaran" class="px-4 py-2 font-bold text-md">Tunai</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="btn btn-primary mr-2 text-white">Bayar</button>
                        <button type="button" class="btn btn-outline" onclick="closeModal()">Close</button>
                    </div>
                </form>
            </div>
        </dialog>


    </div>


    <script>
        function toggleQuantity(checkbox, id) {
            const input = document.getElementById(`quantity-${id}`);
            if (checkbox.checked) {
                // input.removeAttribute('disabled');
                input.setAttribute('readonly', 'readonly');
            } else {
                input.setAttribute('readonly', 'readonly');
                input.value = 0; // Reset quantity to 0 if checkbox is unchecked
            }
            calculateTotal();
        }

        function changeQuantity(id, amount) {
            const input = document.getElementById(`quantity-${id}`);
            const checkbox = input.parentElement.parentElement.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                let currentValue = parseInt(input.value);
                let newValue = currentValue + amount;
                if (newValue >= 0) {
                    input.value = newValue;
                }
            }
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const quantities = document.querySelectorAll('input[type="number"]');
            const prices = document.querySelectorAll('.text-lg.font-semibold.text-gray-700');
            quantities.forEach((quantity, index) => {
                total += parseInt(quantity.value) * parseInt(prices[index].innerText.replace(/\D/g, ''));
            });
            document.getElementById('total-pembayaran').innerText = `Rp ${total.toLocaleString()}`;
        }
    </script>

    <script>
        function showModal() {
            var modal = document.getElementById('my_modal_5');
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var modalTable = modal.querySelector('table tbody');
            var totalBayar = 0;
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            // Bersihkan isi tabel sebelum menambahkan data baru
            modalTable.innerHTML = '';

            checkboxes.forEach(function(checkbox) {
                var item = checkbox.closest('.card-body');
                var namaProduk = item.querySelector('.card-title').innerText;
                var kuantiti = parseInt(item.querySelector('input[type="number"]').value);
                var hargaProduk = parseInt(item.querySelector('.text-lg.font-semibold.text-gray-700').innerText
                    .replace(/\D/g, ''));
                var totalProduk = kuantiti * hargaProduk;

                // Tambahkan data produk ke dalam tabel dengan format IDR
                var newRow = modalTable.insertRow();
                newRow.innerHTML =
                    `<td>${namaProduk}</td><td style='text-align:center'>${kuantiti}</td><td style='text-align:center'>${formatter.format(hargaProduk)}</td><td style='text-align:center'>${formatter.format(totalProduk)}</td>`;

                // Tambahkan total produk ke dalam total bayar
                totalBayar += totalProduk;
            });

            // Update total pembayaran di modal dengan format IDR
            var modalTotalPembayaran = document.getElementById('modal-total-pembayaran');
            modalTotalPembayaran.innerText = formatter.format(totalBayar);

            // Tampilkan modal
            modal.showModal();
        }


        function closeModal() {
            var modal = document.getElementById('my_modal_5');
            modal.close();
        }
    </script>
@endsection --}}

@extends('layout.app')
@section('title')
    Transaksi | Anecake
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
            @foreach ($produk as $item)
                <div class="card w-auto bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center">
                            <input type="checkbox" class="checkbox checkbox-primary mr-2"
                                onchange="toggleQuantity(this, '{{ $item['id'] }}')">
                            <h2 class="card-title">{{ $item['namaProduk'] }}</h2>
                        </div>
                        <p class="text-lg font-semibold text-gray-700">Rp
                            {{ number_format($item['hargaProduk'], 0, ',', '.') }}</p>
                        <div class="flex items-center mt-4">
                            <button class="btn btn-outline btn-primary"
                                onclick="changeQuantity('{{ $item['id'] }}', -1)">-</button>
                            <input type="number" id="quantity-{{ $item['id'] }}" value="0" min="0"
                                class="input input-bordered w-16 mx-2 text-center " readonly>
                            <button class="btn btn-outline btn-primary"
                                onclick="changeQuantity('{{ $item['id'] }}', 1)">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between">
                    <h1 class="text-lg">Metode Pembayaran</h1>
                    <select id="payment-method" class="select select-bordered w-full max-w-xs">
                        <option disabled selected>Pilih Metode Bayar</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Kartu">Kartu</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>
                <div class=" flex justify-between">
                    <h1 class="text-xl">Total Pembayaran</h1>
                    <h2 id="total-pembayaran" class="text-lg">Rp 0</h2>
                </div>
                <div>
                    <form action="">
                        <button class="btn btn-primary btn-block text-white" type="button"
                            onclick="showModal()">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
        8

        
    </div>

    <script>
        function toggleQuantity(checkbox, id) {
            const input = document.getElementById(`quantity-${id}`);
            if (checkbox.checked) {
                input.removeAttribute('readonly');
            } else {
                input.setAttribute('readonly', 'readonly');
                input.value = 0; // Reset quantity to 0 if checkbox is unchecked
            }
            calculateTotal();
        }
    
        function changeQuantity(id, amount) {
            const input = document.getElementById(`quantity-${id}`);
            const checkbox = input.parentElement.parentElement.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                let currentValue = parseInt(input.value);
                let newValue = currentValue + amount;
                if (newValue >= 0) {
                    input.value = newValue;
                }
            }
            calculateTotal();
        }
    
        function calculateTotal() {
            let total = 0;
            const quantities = document.querySelectorAll('input[type="number"]');
            const prices = document.querySelectorAll('.text-lg.font-semibold.text-gray-700');
            quantities.forEach((quantity, index) => {
                total += parseInt(quantity.value) * parseInt(prices[index].innerText.replace(/\D/g, ''));
            });
            document.getElementById('total-pembayaran').innerText = `Rp ${total.toLocaleString()}`;
        }
    
        function showModal() {
            var modal = document.getElementById('my_modal_5');
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var modalTable = modal.querySelector('table tbody');
            var totalBayar = 0;
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
    
            modalTable.innerHTML = '';
    
            checkboxes.forEach(function(checkbox) {
                var item = checkbox.closest('.card-body');
                var namaProduk = item.querySelector('.card-title').innerText;
                var kuantiti = parseInt(item.querySelector('input[type="number"]').value);
                var hargaProduk = parseInt(item.querySelector('.text-lg.font-semibold.text-gray-700').innerText.replace(/\D/g, ''));
                var totalProduk = kuantiti * hargaProduk;
    
                var newRow = modalTable.insertRow();
                newRow.innerHTML = `<td>${namaProduk}</td><td style='text-align:center'>${kuantiti}</td><td style='text-align:center'>${formatter.format(hargaProduk)}</td><td style='text-align:center'>${formatter.format(totalProduk)}</td>`;
    
                totalBayar += totalProduk;
            });
    
            var modalTotalPembayaran = document.getElementById('modal-total-pembayaran');
            modalTotalPembayaran.innerText = formatter.format(totalBayar);
    
            modal.showModal();
        }
    
        function closeModal() {
            var modal = document.getElementById('my_modal_5');
            modal.close();
        }
    
        function sendDataToController() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var totalPembayaran = document.getElementById('total-pembayaran').innerText.replace(/\D/g, '');
            var paymentMethod = document.querySelector('.select').value;
    
            var transactionData = {
                items: [],
                totalPembayaran: totalPembayaran,
                paymentMethod: paymentMethod
            };
    
            checkboxes.forEach(function(checkbox) {
                var item = checkbox.closest('.card-body');
                var idProduk = checkbox.getAttribute('data-id');
                var namaProduk = item.querySelector('.card-title').innerText;
                var kuantiti = parseInt(item.querySelector('input[type="number"]').value);
                var hargaProduk = parseInt(item.querySelector('.text-lg.font-semibold.text-gray-700').innerText.replace(/\D/g, ''));
    
                transactionData.items.push({
                    idProduk: idProduk,
                    namaProduk: namaProduk,
                    kuantiti: kuantiti,
                    hargaProduk: hargaProduk
                });
            });
    
            document.getElementById('transactionData').value = JSON.stringify(transactionData);
            document.getElementById('transactionForm').submit();
        }
    
        document.querySelector('form button[type="submit"]').addEventListener('click', function(event) {
            event.preventDefault();
            sendDataToController();
        });
    </script>
    
@endsection
