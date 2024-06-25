<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseServices;

class addTransaksi extends Controller
{
    protected $database;
    public function __construct()
    {
        $this->database = FirebaseServices::connect();
    }
    public function index()
    {
        $reference = $this->database->getReference('produk');
        $data = $reference->getValue();

        // dd($data);
        if ($data !== null) {
            // Filter out records with 'deleted_at' not set or null in the view
            $filteredData = array_filter($data, function ($item) {
                return !isset($item['deleted_at']) || $item['deleted_at'] === "";
            });

            return view('pages.admin.transaksi.addtransaksi', ['produk' => $filteredData]);
        } else {
            // Jika data kosong, kirimkan array kosong ke view
            return view('pages.admin.transaksi.addtransaksi', ['produk' => []]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $referenceTrlist = $this->database->getReference('transaksiList');
        if (!$referenceTrlist->getSnapshot()->exists()) {
            $referenceTrlist->set([]);
        }
        $dataTrlist = $referenceTrlist->getValue();
        $filteredDataTrlist = array_filter($dataTrlist, function ($entry) {
            return empty($entry['deleted_at']);
        });
        $lastKodeTrlist = end($filteredDataTrlist)['id'] ?? null;
        $newKodeTrlist = $this->generateNewCodeTrlist($lastKodeTrlist);
        $newDataTrlist = [
            $newKodeTrlist => [
                $request->kodeProduk => [
                    'idProduk' =>$request->kodeProduk,
                    'jumlah' =>$request->jumlahProduk,
                ]
            ]
                ];
    }

    protected function generateNewCodeTrlist($lastKode) {
        // Jika tidak ada kode sebelumnya, mulai dengan K001
        if (!$lastKode) {
            return 'TL001';
        }
        // Ambil nomor dari kode terakhir, tambahkan 1, dan format ulang ke dalam K00X
        $number = (int) substr($lastKode, 2); // Ambil angka dari kode terakhir
        $newNumber = $number + 1; // Tambahkan 1 ke nomor terakhir
        $paddedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT); // Format ulang angka ke dalam tiga digit
        $newKode = 'TL' . $paddedNumber;
        return $newKode;
    }
    protected function generateNewCodeTr($lastKode) {
        // Jika tidak ada kode sebelumnya, mulai dengan K001
        if (!$lastKode) {
            return 'TR001';
        }
        // Ambil nomor dari kode terakhir, tambahkan 1, dan format ulang ke dalam K00X
        $number = (int) substr($lastKode, 2); // Ambil angka dari kode terakhir
        $newNumber = $number + 1; // Tambahkan 1 ke nomor terakhir
        $paddedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT); // Format ulang angka ke dalam tiga digit
        $newKode = 'TR' . $paddedNumber;
        return $newKode;
    }
    protected function generateNewCode($lastKode) {
        // Jika tidak ada kode sebelumnya, mulai dengan K001
        if (!$lastKode) {
            return 'P001';
        }
        // Ambil nomor dari kode terakhir, tambahkan 1, dan format ulang ke dalam K00X
        $number = (int) substr($lastKode, 1); // Ambil angka dari kode terakhir
        $newNumber = $number + 1; // Tambahkan 1 ke nomor terakhir
        $paddedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT); // Format ulang angka ke dalam tiga digit
        $newKode = 'P' . $paddedNumber;
        return $newKode;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
