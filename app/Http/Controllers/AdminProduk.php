<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Services\FirebaseServices;

class AdminProduk extends Controller
{
    protected $database;
    public function __construct()
    {
        $this->database = FirebaseServices::connect();
    }

    public function index()
    {
        $reference = $this->database->getReference('produk');
        $referenceKategori = $this->database->getReference('kategori');
        $data = $reference->getValue();
        $dataKategori = $referenceKategori->getValue();

        // dd($data);
        if ($data !== null) {
            // Filter out records with 'deleted_at' not set or null in the view
            $filteredData = array_filter($data, function ($item) {
                return !isset($item['deleted_at']) || $item['deleted_at'] === "";
            });

            foreach ($filteredData as &$produk) {
                foreach ($dataKategori as $kategori) {
                    if ($produk['idKategori'] === $kategori['id']) {
                        if (isset($kategori['deleted_at']) && $kategori['deleted_at'] !== "") {
                            $produk['namaKategori'] = $kategori['namaKategori'] . ' (Dihapus)';
                        } else {
                            $produk['namaKategori'] = $kategori['namaKategori'];
                        }
                        break;
                    }
                }
            }
            return view('pages.admin.produk', ['produk' => $filteredData, 'dataKategori' => $dataKategori]);
        } else {
            // Jika data kosong, kirimkan array kosong ke view
            return view('pages.admin.produk', ['produk' => []]);
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
    public function update(Request $request, $kode)
    {
        $reference = $this->database->getReference('produk/' . $kode);

        // Fetch existing data
        $existingData = $reference->getValue();

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Jika ada gambar baru diunggah
            $uploadedFile = $request->file('gambar');
            $namaProduk = str_replace(' ', '', $request->namaProduk);
            $extension = $uploadedFile->getClientOriginalExtension();
            $namaFotoBaru = $kode . $namaProduk . '.' . $extension;

            // Konfigurasi Firebase
            $factory = (new Factory)->withServiceAccount(base_path('firebase_credentials.json'));
            $storage = $factory->createStorage();
            $bucket = $storage->getBucket('anecake-c6dfc.appspot.com');

            // Simpan file baru ke Firebase Storage
            $object = $bucket->upload(
                fopen($uploadedFile->getRealPath(), 'r'),
                [
                    'name' => 'produk/' . $namaFotoBaru,
                ]
            );

            // Dapatkan URL file yang diunggah
            $url = $object->signedUrl(new \DateTime('+10 years'));

            // Hapus file lama dari Firebase Storage jika ada
            if (isset($existingData['gambar']) && $existingData['gambar'] !== null) {
                $oldUrl = $existingData['gambar'];
                $parsedUrl = parse_url($oldUrl);
                $pathInfo = pathinfo($parsedUrl['path']);
                $fileName = $pathInfo['basename'];

                // Hapus file dari Firebase Storage
                $objectToDelete = $bucket->object('produk/' . $fileName);

                // Hapus file hanya jika ada
                if ($objectToDelete->exists()) {
                    $objectToDelete->delete();
                }
            }
        } else {
            // Jika tidak ada foto baru diunggah, gunakan URL foto yang sudah ada atau atur menjadi null
            $url = $existingData['gambar'] ?? null;
        }

        // Update the data
        $updatedData = [
            'id' => $kode,
            'namaProduk' => $request->namaProduk,
            'idKategori' => $request->namaKategori,
            'gambar' => $url,
            'stokProduk' => $request->stokProduk,
            'hargaProduk' => $request->hargaProduk,
            'deskripsi' => $request->deskripsi,
            'deleted_at' => $request->deleted_at !== '' ? $request->deleted_at : '-',
        ];

        $reference->update($updatedData);

        toast('Data Produk berhasil diupdate!','success');
        return redirect('/produk');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode)
{
    // Mendapatkan referensi ke data produk yang akan dihapus
    $reference = $this->database->getReference('produk/' . $kode);
    
    // Menghapus data produk dari database
    $reference->remove();

    // Menampilkan pesan sukses menggunakan package alert
    alert()->success('Berhasil', 'Produk berhasil dihapus');

    // Redirect ke halaman yang diinginkan, misalnya halaman produk
    return redirect('/produk');
}
}
