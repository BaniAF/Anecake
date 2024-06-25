<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseServices;

class AdminKategori extends Controller
{
    protected $database;
    public function __construct()
    {
        $this->database = FirebaseServices::connect();
    }
    
    public function index()
    {
        $reference = $this->database->getReference('kategori');
        $data = $reference->getValue();

        // dd($data);
        if ($data !== null) {
            // Filter out records with 'deleted_at' not set or null in the view
            $filteredData = array_filter($data, function ($item) {
                return !isset($item['deleted_at']) || $item['deleted_at'] === "";
            });

            return view('pages.admin.kategori', ['dataKategori' => $filteredData]);
        } else {
            // Jika data kosong, kirimkan array kosong ke view
            return view('pages.admin.kategori', ['dataKategori' => []]);
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
        toast('Data Kategori berhasil ditambahkan!','success');
        return redirect('/kategori');
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
    public function Update(Request $request, $kode) {
        $reference = $this->database->getReference('kategori');

        // Ambil data yang akan diedit berdasarkan kode
        $dataToEdit = $reference->getChild($kode)->getValue();

        // Cek apakah data ditemukan
        if ($dataToEdit) {
            // Lakukan perubahan sesuai dengan data baru
            $dataToEdit['namaKategori'] = $request->editKategori;

            // Update data di Firebase Realtime Database
            $reference->getChild($kode)->update($dataToEdit);

            alert()->success('Berhasil', 'Data Berhasil di Update.');
            return redirect('/kategori');
        } else {
            alert()->error('Error', 'Data tidak ditemukan.');
            return redirect('/kategori');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode)
    {
        $reference = $this->database->getReference('kategori/' . $kode);
        if (isset($existingData['deleted_at'])) {
            // If 'deleted_at' field exists, update it
            $reference->update(['deleted_at' => now()]);
        } else {
            // If 'deleted_at' field doesn't exist, add it and set it to now()
            $reference->update(['deleted_at' => now()]);
        }
        // Show a success Toast
        alert()->success('Berhasil','Kategori Belajar berhasil dihapus');
        return redirect('/kategori');
    }
}
