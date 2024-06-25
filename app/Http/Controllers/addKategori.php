<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseServices;

class addKategori extends Controller
{
    protected $database;
    public function __construct()
    {
        $this->database = FirebaseServices::connect();
    }
    
    public function index()
    {
        return view('pages.admin.kategori.addkategori');
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

     protected function generateNewCode($lastKode) {
        // Jika tidak ada kode sebelumnya, mulai dengan K001
        if (!$lastKode) {
            return 'KT001';
        }

        // Ambil nomor dari kode terakhir, tambahkan 1, dan format ulang ke dalam K00X
        $number = (int) substr($lastKode, 2); // Ambil angka dari kode terakhir
        $newNumber = $number + 1; // Tambahkan 1 ke nomor terakhir
        $paddedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT); // Format ulang angka ke dalam tiga digit
        $newKode = 'KT' . $paddedNumber;

        return $newKode;
    }

    public function store(Request $request)
    {
        $reference = $this->database->getReference('kategori');
        $data = $reference->getValue();

        $filteredData = array_filter($data, function ($entry) {
            return empty($entry['deleted_at']);
        });

        $lastKode = end($filteredData)['id'] ?? null;
        $newKode = $this->generateNewCode($lastKode);
// dd($request->all());

        $newData = [
            $newKode => [
                'id' => $newKode,
                'namaKategori' => $request->namaKategori,
                'deleted_at' => $request->deleted_at !== '' ? $request->deleted_at : '-',

                // Sesuaikan dengan nama kolom dan nilai dari formulir
            ]
        ];
        $reference->update($newData); 
        // alert()->success('Berhasil','Data Berhasil di Tambahkan.');
        return redirect('/kategori');
    }

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
