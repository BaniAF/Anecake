<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseServices;

class landingController extends Controller
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

            return view('pages.landing.home', ['dataProduk' => $filteredData]);
        } else {
            // Jika data kosong, kirimkan array kosong ke view
            return view('pages.landing.home', ['dataProduk' => []]);
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
        //
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
