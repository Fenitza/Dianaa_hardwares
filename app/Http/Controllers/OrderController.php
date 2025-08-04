<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use App\Models\Order;
use App\Models\CartItem;
use App\Models\User;

use App\Models\Product;
use App\Models\ProductColorVariant;
use App\Mail\OrderConfirmation;
use App\Mail\BulkOrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $user = Auth::user();
            $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Your cart is empty'], 400);
            }

            $totalAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $billingDetails = json_encode([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country
            ]);

            // Create order entry in database
            $order = Order::create([
                'user_id' => $user->id,
                'order_id' => $request->order_id, // Razorpay Order ID
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'billing_details' => $billingDetails
            ]);

            // Store order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->ProductID,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]);
            }

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'amount' => $totalAmount * 100
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
/**
     * Handle checkout form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function placeOrder(Request $request)
{
    \Log::info('Received order data:', $request->all());

    try {
        // Validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'shipping' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // Eager-load product to avoid null error
        $cartItems = \App\Models\CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        // Calculate total
        $totalAmount = $validatedData['total']; // Use frontend-confirmed total
        $actualWeight = $validatedData['weight'] / 1000;
        $shipping = $validatedData['shipping'];

        // Generate unique order ID
        $uniqueOrderId = strtoupper('ORD-' . dechex(time()) . '-' . dechex($user->id));

        // Create order
        $order = new \App\Models\Order([
            'order_id' => $uniqueOrderId,
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'weight' => (float) $actualWeight,
            'shipping' => $shipping,
            'payment_status' => 'pending',
            'billing_details' => json_encode($validatedData),
        ]);
        $order->save();

        // Save order items 
        foreach ($cartItems as $item) {
            $order->items()->create([
                'order_id' => $order->order_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => floatval($item->selected_price),
                'variant' => $item->selected_color ?? null,

            ]);
        }

        // Store in session (for success page)
        $order = \App\Models\Order::with(['items.product'])->find($order->id);
        session(['order' => $order]);

        // ✅ Return JSON success response
        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully.',
            'order_id' => $order->order_id
        ]);

    } catch (\Exception $e) {
        \Log::error("Error in placeOrder: " . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Order placement failed.',
            'error' => $e->getMessage()
        ], 500);
    }
}



    public function showOrders(Request $request)
{
    $search = $request->input('search', '');
    $perPage = $request->input('perPage', 10);

    $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                   ->leftJoin('order_items', 'orders.order_id', '=', 'order_items.order_id')
                   ->leftJoin('products', 'order_items.product_id', '=', 'products.ProductID')
                   ->select(
                       'orders.order_id',
                       'users.name as user_name',
                       'users.email',
                       DB::raw('GROUP_CONCAT(DISTINCT CONCAT(order_items.quantity, "x", products.name, "<br>", " (SKU: ", products.sku, ")") SEPARATOR "<br><br>" ) as product_details'),
                       DB::raw('CONCAT(
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.address")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.city")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.state")), " ",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.postal_code"))
                       ) AS shipping_address'),
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.created_at'
                   )
                   ->where('orders.order_id', 'like', '%' . $search . '%')
                   ->groupBy(
                       'orders.order_id',
                       'users.name',
                       'users.email',
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.billing_details',
                       'orders.created_at'
                   )
                   ->simplePaginate($perPage);


    return view('includes.admin.orders.index', compact('orders'));
}
public function show($id)
{
    $order = Order::with(['items.product.manufacturer'])
              ->where('order_id', $id)
              ->firstOrFail();
    $billingDetails = json_decode($order->billing_details);

    return view('includes.admin.orders.show', compact('order', 'billingDetails'));
}

public function updateTracking(Request $request, $id)
{
    $request->validate([
        'tracking_id' => 'nullable|string|max:255'
    ]);

    $order = Order::findOrFail($id);
    $order->tracking_id = $request->tracking_id;
    $order->save();

    return redirect()->back()->with('success', 'Tracking ID updated successfully.');
}


public function orderUser(Request $request)
{
    $search = $request->input('search', '');
    $perPage = $request->input('perPage', 10);

    $userId = Auth::id(); // Get the authenticated user's ID

    $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                   ->leftJoin('order_items', 'orders.order_id', '=', 'order_items.order_id')
                   ->leftJoin('products', 'order_items.product_id', '=', 'products.ProductID')
                   ->select(
                       'orders.order_id',
                       'orders.tracking_id', // ✅ include tracking ID
                       'users.name as user_name',
                       'users.email',
                       DB::raw('GROUP_CONCAT(DISTINCT CONCAT(order_items.quantity, "x", products.name, "<br>", " (SKU: ", products.sku, ")") SEPARATOR "<br><br>" ) as product_details'),
                       DB::raw('CONCAT(
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.address")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.city")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.state")), " ",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.postal_code"))
                       ) AS shipping_address'),
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.created_at'
                   )
                   ->where('orders.user_id', $userId)
                   ->where('orders.order_id', 'like', '%' . $search . '%')
                   ->groupBy(
                       'orders.order_id',
                       'orders.tracking_id', // ✅ group by this too
                       'users.name',
                       'users.email',
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.billing_details',
                       'orders.created_at'
                   )
                   ->simplePaginate($perPage);

    return view('includes.user.orders.index', compact('orders'));
}


public function userShow($order_id)
{
    $user = Auth::user();

    $order = Order::with(['items.product.manufacturer'])
                ->where('user_id', $user->id)
                ->where('order_id', $order_id)
                ->firstOrFail();

    return view('includes.user.orders.show', compact('order'));
}
 
// place bulk order
public function handleBulkOrder(Request $request)
{
    
    Log::info('Received AJAX data:', $request->all());

    if (!$request->has(['productId', 'quantity', 'message'])) {
        return response()->json(['error' => 'Missing necessary data'], 400);
    }

    try {
        $emailData = $request->all();
        Mail::to('dianaafastners@gmail.com',
        'benedict@dhw.co.in',
                'nirmal@dhw.co.in',
                'dianaadigital2024@gmail.com')->send(new BulkOrderMail($emailData));
        return response()->json(['message' => 'Your bulk order request has been sent.']);
    } catch (\Exception $e) {
        Log::error('Mail sending error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to send email, please try again.'], 500);
    }
}

public function generateWaybill(Request $request, $id)
{
    \Log::info('generateWaybill called');
    $request->validate([
        'pickup_date' => 'required|date|after_or_equal:today',
        'shipper_customer_name' => 'required|string',
        'shipper_customer_mobile' => 'required|string',
        'shipper_customer_email' => 'nullable|email',
        'shipper_customer_pincode' => 'required|string',
        'shipper_customer_address1' => 'required|string',
        'shipper_customer_address2' => 'nullable|string',
        'shipper_customer_address3' => 'nullable|string',
        'shipper_origin_area' => 'required|string',
        
    ]);

    $order = Order::with(['items.product'])->where('id', $id)->firstOrFail();
    $billing = json_decode($order->billing_details); // Assuming billing_details is stored as JSON

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

    $actualWeight = round($order->weight, 2);

    if ($actualWeight > 10) {
        $productCode = 'A';
        $subProductCode = 'P';
        $packType = 'L';
    } else {
        $productCode = 'E';
        $subProductCode = 'P';
        $packType = '';
    }

    // Build BlueDart API payload
    $payload = [
    "Request" => [
        "Shipper" => [
            "CustomerName" => $request->input('shipper_customer_name'),
            "CustomerMobile" => $request->input('shipper_customer_mobile'),
            "CustomerEmailID" => $request->input('shipper_customer_email'),
            "CustomerPincode" => $request->input('shipper_customer_pincode'),
            "CustomerAddress1" => $request->input('shipper_customer_address1'),
            "CustomerAddress2" => $request->input('shipper_customer_address2'),
            "CustomerAddress3" => $request->input('shipper_customer_address3'),
            "CustomerAddressinfo" => "",
            "CustomerBusinessPartyTypeCode" => "",
            "CustomerCode" => "000416",
            "CustomerGSTNumber" => "",
            "CustomerLatitude" => "",
            "CustomerLongitude" => "",
            "CustomerMaskedContactNumber" => "",
            "CustomerTelephone" => "",
            "IsToPayCustomer" => true,
            "OriginArea" => $request->input('shipper_origin_area'),
            "Sender" => "",
            "VendorCode" => ""
        ],
        "Consignee" => [
            "ConsigneeName" => $billing->name,
            "ConsigneeAddress1" => $billing->address_line_1 ?? $billing->address,
            "ConsigneeAddress2" => $billing->address_line_2 ?? "",
            "ConsigneeAddress3" => "",
            "ConsigneeAddressinfo" => "",
            "ConsigneeAttention" => $billing->attention_name ?? "",
            "ConsigneeEmailID" => $billing->email,
            "ConsigneeFullAddress" => "",
            "ConsigneeGSTNumber" => "",
            "ConsigneeLatitude" => "",
            "ConsigneeLongitude" => "",
            "ConsigneeMaskedContactNumber" => "",
            "ConsigneeMobile" => $billing->phone,
            "ConsigneePincode" => $billing->postal_code,
            "ConsigneeTelephone" => "",
            "AvailableDays" => "",
            "AvailableTiming" => ""
        ],
        "Returnadds" => [
            "ManifestNumber" => "",
            "ReturnAddress1" => $request->input('shipper_customer_address1'),
            "ReturnAddress2" => $request->input('shipper_customer_address2'),
            "ReturnAddress3" => $request->input('shipper_customer_address3'),
            "ReturnAddressinfo" => "",
            "ReturnContact" => $request->input('shipper_customer_name'),
            "ReturnEmailID" => $request->input('shipper_customer_email'),
            "ReturnLatitude" => "",
            "ReturnLongitude" => "",
            "ReturnMaskedContactNumber" => "",
            "ReturnMobile" =>  $request->input('shipper_customer_mobile'),
            "ReturnPincode" => $request->input('shipper_customer_pincode'),
            "ReturnTelephone" => ""
        ],
        "Services" => [
            "AWBNo" => "", // leave blank to generate new AWB
            "ActualWeight" => $actualWeight,
            "CollectableAmount" => 0,
            "Commodity" => [
                "CommodityDetail1" => "General Goods",
                "CommodityDetail2" => "",
                "CommodityDetail3" => ""
            ],
            "CreditReferenceNo" => $order->order_id,
            "CreditReferenceNo2" => "",
            "CreditReferenceNo3" => "",
            "DeclaredValue" => $order->total_amount,
            "DeliveryTimeSlot" => "",
            "Dimensions" => [[
                "Length" => 1,
                "Breadth" =>  1,
                "Height" => 1,
                "Count" => 1,
            ]],
            "FavouringName" => "",
            "IsDedicatedDeliveryNetwork" => "0",
            "IsDutyTaxPaidByShipper" => "0",
            "IsForcePickup" => "0",
            "IsPartialPickup" => "0",
            "IsReversePickup" => "0",
            "ItemCount" => 1,
            "Officecutofftime" => "",
            "PDFOutputNotRequired" => true,
            "PackType" => $packType,
            // "PackType" => ($order->weight) > 10 ? 'L' : '',
            "ParcelShopCode" => "",
            "PayableAt" => "",
            "PickupDate" => "/Date(" . (strtotime($request->pickup_date) * 1000) . ")/",
            "PickupMode" => "",
            "PickupTime" => "1600",
            "PickupType" => "",
            "PieceCount" => 1,
            "PreferredPickupTimeSlot" => "",
            "ProductCode" => $productCode,  // Use correct product code
            "ProductFeature" => "",
            "ProductType" => 1,
            "RegisterPickup" => true,
            "SpecialInstruction" => "",
            "SubProductCode" =>$subProductCode,
            "TotalCashPaytoCustomer" => 0,
            "itemdtl" => $order->items->map(function ($item) use ($order) {
                return [
                    "CGSTAmount" => 0,
                    "HSCode" => "",
                    "IGSTAmount" => 0,
                    "Instruction" => "",
                    "InvoiceDate" => "/Date(" . (strtotime($order->created_at) * 1000) . ")/",
                    "InvoiceNumber" =>  $order->order_id,
                    "ItemID" => (string) $item->id,
                    "ItemName" => $item->product->Description ?? 'Unknown Product',
                    "ItemValue" => $item->price,
                    "Itemquantity" => 1,
                    "PlaceofSupply" => "",
                    "ProductDesc1" => "",
                    "ProductDesc2" => "",
                    "ReturnReason" => "",
                    "SGSTAmount" => 0,
                    "SKUNumber" => $item->product->sku ?? "",
                    "SellerGSTNNumber" => "",
                    "SellerName" => "",
                    "SubProduct1" => "",
                    "SubProduct2" => "",
                    "TaxableAmount" => 0,
                    "TotalValue" => $item->price * $item->quantity,
                    "cessAmount" => "0.0",
                    "countryOfOrigin" => "",
                    "docType" => "",
                    "subSupplyType" => 0,
                    "supplyType" => ""
                ];
            })->values()->toArray(),
            "noOfDCGiven" => 0
        ],
    ],
    "Profile" => [
        "LoginID" => "$loginID",
        "LicenceKey" => "$licenseKey",
        "Api_type" => "S"
    ]
];

 Log::info('🔄 Bluedart Waybill Payload:');
Log::info(print_r($payload, true));
Log::info(print_r($jwtToken, true));

    // Make request to BlueDart
    $response = Http::withHeaders([
    'Content-Type' => 'application/json',
    'JWTToken' => $jwtToken,
])
->withBody(json_encode($payload), 'application/json')
->post('https://apigateway-sandbox.bluedart.com/in/transportation/waybill/v1/GenerateWayBill');

// Log full response for debugging
Log::info('Bluedart waybill response', [
    'status' => $response->status(),
    'body' => $response->body()
]);

if ($response->successful()) {
    $data = $response->json();
    $result = $data['GenerateWayBillResult'] ?? [];

    $awbNo = $result['AWBNo'] ?? null;
    $isError = $result['IsError'] ?? true;

    if ($awbNo && !$isError) {
        // Store AWB in DB
        $order->update(['awb_number' => $awbNo]);

        return back()->with('success', "Waybill generated successfully: $awbNo");
    }

    // Get detailed error messages
    $statusMessages = collect($result['Status'] ?? [])
        ->pluck('StatusInformation')
        ->filter()
        ->implode(', ') ?: 'Unknown error from Bluedart';

    return back()->with('error', "Waybill generation failed: $statusMessages");
}

// Handle other HTTP errors (400, 500, etc.)
return back()->with('error', 'Bluedart API error: ' . $response->body());
}


}