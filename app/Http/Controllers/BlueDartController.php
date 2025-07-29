<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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

