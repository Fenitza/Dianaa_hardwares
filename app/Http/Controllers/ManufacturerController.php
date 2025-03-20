<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Manufacturer;
use App\Models\Product;

use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
    $perPage = $request->input('perPage', 10); // Default to 10 items per page

    // Fetch manufacturers based on search criteria and paginate them
    $manufacturers = Manufacturer::where('name', 'like', '%' . $search . '%')
                                 ->orderBy('name') // Sorting manufacturers alphabetically
                                 ->paginate($perPage);
        return view('includes.admin.manufacturers', compact('manufacturers'));
    }

    public function create()
    {
        return view('includes.admin.manufacturers.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'manufacturer_image' => 'required|image|max:2048', // Allow for image uploads up to 2MB
    ]);

    $manufacturer = new Manufacturer();
    $manufacturer->fill($data);
    $manufacturer->name = $data['name'];
    if ($request->hasFile('manufacturer_image')) {
        $manufacturer->Image = $request->file('manufacturer_image')->store('manufacturers', 'public');
    }

    $manufacturer->save();

    return redirect()->route('admin.manufacturers')->with('success', 'Manufacturer added successfully.');
}

public function update(Request $request, Manufacturer $manufacturer)
{
    // Validate the incoming request data
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'manufacturer_image' => 'required|image|max:2048',// Allowing for common image formats
    ]);

    // Check if a new image file was uploaded
    if ($request->hasFile('manufacturer_image')) {
        // Check if there's an existing image and delete it from storage if it exists
        if ($manufacturer->Image && Storage::disk('public')->exists($manufacturer->Image)) {
            Storage::disk('public')->delete($manufacturer->Image);
        }

        // Store the new image in the 'manufacturers' directory within public storage
        $imagePath = $request->file('manufacturer_image')->store('manufacturers', 'public');
        // Update the image path in the manufacturer instance
        $manufacturer->Image = $imagePath; // Ensure this attribute is correct and matches your database column
    }

    // Update other data fields
    $manufacturer->name = $data['name'];
    $manufacturer->save(); // Save the changes explicitly

    // Redirect back to the manufacturers list with a success message
    return redirect()->route('admin.manufacturers')->with('success', 'Manufacturer updated successfully.');
}

    public function edit(Manufacturer $manufacturer)
    {
        return view('includes.admin.manufacturers.edit', compact('manufacturer'));
    }


    public function destroy(Manufacturer $manufacturer)
    {
        // Check if the manufacturer has any linked products
        if ($manufacturer->products()->exists()) {
            return redirect()->route('admin.manufacturers')
                             ->with('error', 'This manufacturer cannot be deleted because it is linked to one or more products.');
        }
    
        // Proceed with deletion if no products are linked
        $manufacturer->delete();
        return redirect()->route('admin.manufacturers')->with('success', 'Manufacturer deleted successfully.');
    }
}
