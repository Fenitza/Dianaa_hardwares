<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BlueDartController extends Controller
{

public function checkPincode(Request $request)
{
    \Log::info('Pincode received:', ['pincode' => $request->pincode]);
    $request->validate([
        'pincode' => 'required|digits:6'
    ]);

    $pincode = $request->input('pincode');

    $clientID = env('BLUEDART_CLIENT_ID');
    $clientSecret = env('BLUEDART_CLIENT_SECRET');
    $loginID = env('BLUEDART_LOGIN_ID');
    $licenseKey = env('BLUEDART_LICENSE_KEY');

    \Log::info('Making token request', [
    'url' => 'https://apigateway-sandbox.bluedart.com/in/transportation/token/v1/login',
    'clientID' => $clientID,
    'clientSecret' => $clientSecret
]);

    // Step 1: Get JWT Token (cached daily)
    $jwtToken = Cache::remember('bluedart_jwt_token', now()->addDay(), function () use ($clientID, $clientSecret) {
    \Log::info('Requesting BluDart token', ['clientID' => $clientID]);

    $response = Http::withHeaders([
        'ClientID' => $clientID,
        'ClientSecret' => $clientSecret,
    ])->get('https://apigateway-sandbox.bluedart.com/in/transportation/token/v1/login');

    \Log::info('BluDart token response status', ['status' => $response->status()]);
    \Log::info('BluDart token response body', ['body' => $response->body()]);

    if ($response->successful()) {
        $tokenData = $response->json();
        return $tokenData['JWTToken'] ?? null;
    }

    return null;
});

    if (!$jwtToken) {
        return response()->json([
            'available' => false,
            'error' => 'Failed to generate JWT token.'
        ], 500);
    }

    // Step 2: Check pincode with BluDart
    $payload = [
        "pinCode" => $pincode,
        "profile" => [
            "Api_type" => "S",
            "LicenceKey" => $licenseKey,
            "LoginID" => $loginID
        ]
    ];

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'JWTToken' => $jwtToken
    ])->post('https://apigateway-sandbox.bluedart.com/in/transportation/finder/v1/GetServicesforPincode', $payload);

    $responseData = $response->json();

    \Log::info('Bluedart pincode response', [
        'status' => $response->status(),
        'response' => $responseData,
    ]);

    $isAvailable = false;

    if (
        isset($responseData['GetServicesforPincodeResult']) &&
        isset($responseData['GetServicesforPincodeResult']['IsError']) &&
        $responseData['GetServicesforPincodeResult']['IsError'] === false
    ) {
        $isAvailable = true;
    }

    return response()->json([
        'available' => $isAvailable,
        'data' => $responseData['GetServicesforPincodeResult'] ?? null,
    ]);
}    
private function getStateFromPincode($pincode)
{
    try {
        $response = Http::withHeaders([
    'User-Agent' => 'Mozilla/5.0 (compatible; LaravelApp/1.0)'
])->timeout(7)->get("https://api.postalpincode.in/pincode/{$pincode}"); // 3 retries, 100ms delay

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data[0]['PostOffice'][0]['State'])) {
                return $data[0]['PostOffice'][0]['State'];
            }
        }
    } catch (\Exception $e) {
        Log::error('Failed to retrieve state from pincode API', [
            'pincode' => $pincode,
            'error' => $e->getMessage()
        ]);
    }

    return null;
}

    public function getShippingCharge(Request $request)
{
    $pincode = $request->input('pincode');
    $weightInGrams = $request->input('weight');
Log::info('Shipping Charge Requested', [
        'pincode' => $pincode,
        'weight_in_grams' => $weightInGrams
    ]);
    // Convert to kg and round up
    $weightInKg = ceil($weightInGrams / 1000);


    if ($weightInKg <= 10) {
        return response()->json([
            'success' => false,
            'message' => 'Shipping only available for packages over 10 kg.',
        ]);
    }

    $state = $this->getStateFromPincode($pincode);

if (!$state) {
    Log::error('Failed to retrieve state for pincode', ['pincode' => $pincode]);

    return response()->json([
        'success' => false,
        'message' => 'Invalid or unserviceable pincode.',
    ]);
}

// Log successful state resolution
Log::info('Pincode processed successfully', [
    'pincode' => $pincode,
    'resolved_state' => $state
]);

$state = ucwords(strtolower(trim($state)));


    // Map state to region
    $stateRegionMap = [
        'Himachal Pradesh' => 'NORTH', 'Punjab' => 'NORTH', 'Haryana' => 'NORTH',
        'Uttarakhand' => 'NORTH', 'Uttar Pradesh' => 'NORTH', 'Rajasthan' => 'NORTH',
        'Delhi' => 'NORTH', 'Chandigarh' => 'NORTH',

        'Bihar' => 'EAST', 'Odisha' => 'EAST', 'West Bengal' => 'EAST',
        'Jharkhand' => 'EAST', 'Assam' => 'EAST',

        'Maharashtra' => 'WEST', 'Madhya Pradesh' => 'WEST', 'Gujarat' => 'WEST',
        'Chhattisgarh' => 'WEST', 'Goa' => 'WEST', 'Daman and Diu' => 'WEST',

        'Karnataka' => 'SOUTH', 'Tamil Nadu' => 'SOUTH', 'Kerala' => 'SOUTH',
        'Andhra Pradesh' => 'SOUTH', 'Telangana' => 'SOUTH', 'Puducherry' => 'SOUTH',

        'Nagaland' => 'NE', 'Mizoram' => 'NE', 'Manipur' => 'NE', 'Meghalaya' => 'NE',
        'Arunachal Pradesh' => 'NE', 'Tripura' => 'NE', 'Sikkim' => 'NE',

        'Jammu & Kashmir' => 'NE', 'Ladakh' => 'NE',
    ];

    $region = $stateRegionMap[$state] ?? null;

    if (!$region) {
        return response()->json([
            'success' => false,
            'message' => "State '$state' not mapped to a shipping region.",
        ]);
    }

    $regionRates = [
        'SOUTH' => 321,
        'WEST' => 350,
        'NORTH' => 378,
        'EAST' => 392,
        'NE' => 548,
        'J&K' => 548,
    ];

    $ratePer10Kg = $regionRates[$region];

    // Round up to nearest 10kg block (e.g., 13kg → 20kg)
    $weightBlock = ceil($weightInKg / 10);

    // Final shipping charge
    $shippingCharge = $ratePer10Kg * $weightBlock;


    return response()->json([
        'success' => true,
        'state' => $state,
        'region' => $region,
        'weight_kg' => $weightInKg,
        'shipping_charge' => $shippingCharge,
    ]);
}

// helper function

}