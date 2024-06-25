<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Services\FirebaseServices;

class addProduk extends Controller
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

            return view('pages.admin.produk.addProduk', ['dataKategori' => $filteredData]);
        } else {
            // Jika data kosong, kirimkan array kosong ke view
            return view('pages.admin.produk.addProduk', ['dataKategori' => []]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function store(Request $request)
    {
        $reference = $this->database->getReference('produk');

        if (!$reference->getSnapshot()->exists()) {
            $reference->set([]);
        }

        $data = $reference->getValue();

        if (!is_array($data)) {
            $data = [];
        }

        $filteredData = array_filter($data, function ($entry) {
            return empty($entry['deleted_at']);
        });

        $lastKode = end($filteredData)['id'] ?? null;

        $newKode = $this->generateNewCode($lastKode);

        if ($request->hasFile('gambar')) {
            $uploadedFile = $request->file('gambar');
            $namaProduk = str_replace(' ', '', $request->namaProduk);
            $extension = $uploadedFile->getClientOriginalExtension();
            $namaFoto = $newKode . $namaProduk . '.' . $extension;

            $factory = (new Factory)->withServiceAccount(base_path('firebase_credentials.json'));
            $storage = $factory->createStorage();
            $bucket = $storage->getBucket('anecake-c6dfc.appspot.com');
            $object = $bucket->upload(
                fopen($uploadedFile->getRealPath(), 'r'),
                ['name' => 'produk/' . $namaFoto]
            );

            $url = $object->signedUrl(new \DateTime('+10 years'));
        } else {
            $url = '-';
        }

        $newData = [
            $newKode => [
                'id' => $newKode,
                'namaProduk' => $request->namaProduk,
                'idKategori' => $request->namaKategori,
                'gambar' => $url,
                'stokProduk' => $request->stokProduk,
                'hargaProduk' => $request->hargaProduk,
                'deskripsi' => $request->deskripsi,
                'deleted_at' => $request->deleted_at !== '' ? $request->deleted_at : '-',
            ]
        ];

        $reference->update($newData);

        toast('Data Produk berhasil ditambahkan!','success');
        return redirect('/produk');
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
