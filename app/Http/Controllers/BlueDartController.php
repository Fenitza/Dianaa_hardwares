<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlueDartController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'pincode' => 'required|digits:6'
        ]);

        $pincode = $request->input('pincode');
        $countryCode = 'IN'; // You can make this dynamic if needed
        $apiKey = 'vsm79RlWYu5FmZIhDAtSmKACuD0FAiwV'; // Replace with env() if stored in .env

        try {
            $response = Http::withHeaders([
                'DHL-API-Key' => $apiKey,
            ])->get('https://api.dhl.com/location-finder/v1/locations', [
                'countryCode' => $countryCode,
                'postalCode' => $pincode
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $locations = $data['locations'] ?? [];

                return response()->json([
                    'available' => count($locations) > 0,
                    'locations' => $locations,
                ]);
            } else {
                return response()->json([
                    'available' => false,
                    'error' => 'DHL API returned an error: ' . $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'available' => false,
                'error' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getToken()
    {
        // Replace with actual token generation using Client ID & Secret
        return 'your-jwt-token-here';
    }

    public function getShippingCharge(Request $request)
{
    $pincode = $request->input('pincode');
    $weightInGrams = $request->input('weight'); // e.g. 1500 grams

    // Convert to kg and round up
    $weightInKg = ceil($weightInGrams / 1000);

    // Mock pricing logic — replace with actual Blue Dart rate logic or API
    $baseRate = 35; // base rate per kg
    $remoteAreaFee = 50; // optional for remote areas

    // Optionally, check if pincode is serviceable or remote
    $isRemote = in_array($pincode, ['721001', '799005']); // example pincodes
    $shippingCharge = $weightInKg * $baseRate + ($isRemote ? $remoteAreaFee : 0);

    return response()->json([
        'success' => true,
        'shipping_charge' => $shippingCharge,
    ]);
}

}

