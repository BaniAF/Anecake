<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LEDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('led-control');
    }

    public function control(Request $request)
    {
        $request->validate([
            'state' => 'required|boolean',
        ]);

        $state = $request->input('state');
        $esp32Ip = 'http://192.168.1.50'; // Ganti dengan IP ESP32 Anda

        $response = Http::post("{$esp32Ip}/led", [
            'state' => $state,
        ]);

        return response()->json($response->json(), $response->status());
    }

    public function status()
    {
        $esp32Ip = 'http://192.168.1.50'; // Ganti dengan IP ESP32 Anda

        try {
            $response = Http::get("{$esp32Ip}/status");
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['status' => 'disconnected'], 500);
        }
    }

    public function ledStatus()
    {
        $esp32Ip = 'http://192.168.1.50'; // Ganti dengan IP ESP32 Anda

        try {
            $response = Http::get("{$esp32Ip}/led-status");
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['led_status' => 'unknown'], 500);
        }
    }

}
