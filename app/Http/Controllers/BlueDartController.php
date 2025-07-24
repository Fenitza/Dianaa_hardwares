<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlueDartController extends Controller
{
    public function checkPincode(Request $request)
    {
        $pincode = $request->input('pincode');
        
        // Sample JWT token (replace with your actual token generation logic)
        $token = $this->getToken(); // You may store it in cache or session

        $response = Http::withToken($token)
            ->post('https://bluedart-api-url/transit-time', [
                'originArea' => 'Mumbai', // or dynamic
                'destinationPincode' => $pincode,
                'productCode' => 'A', // A for Express, E for Economy etc.
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $available = isset($data['TransitAvailable']) && $data['TransitAvailable'] === true;

            return response()->json(['available' => $available]);
        } else {
            return response()->json(['available' => false], 500);
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

