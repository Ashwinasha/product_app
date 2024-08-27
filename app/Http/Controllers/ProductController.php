<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Method to display the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Method to store the new product
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'model_number' => 'required|string|max:255',
            'category' => 'required|string',
            'product_details' => 'required|string',
            'how_to_use' => 'required|string',
            'shipping_details' => 'required|string',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'qty_of_box' => 'required|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'small_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create a new Product instance with the validated data
        $product = new Product($request->except(['main_image', 'small_images']));

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            $product->main_image = $path;
        }

        // Handle small images upload
        if ($request->hasFile('small_images')) {
            $smallImages = [];
            foreach ($request->file('small_images') as $image) {
                $path = $image->store('products', 'public');
                $smallImages[] = $path;
            }
            $product->small_images = json_encode($smallImages);  // Store small images as JSON
        }

        // Save the product to the database
        $product->save();

        // Redirect back to the create form with a success message
        return redirect()->route('products.create')->with('success', 'Product added successfully!');
    }

    // Method to display a specific product
    public function show($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Pass the product data to the view
        return view('products.show', compact('product'));
    }

    public function index()
    {
        // Fetch products with pagination
        $products = Product::paginate(18); // Adjust the number to match your desired items per page
    
        // Return the view with paginated products
        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        // Fetch the product by ID
        $product = Product::findOrFail($id);

         // Ensure small_images is always an array
         $product->small_images = json_decode($product->small_images, true) ?? [];
        
        // Return the edit view with the product details
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'model_number' => 'required|string|max:255',
        'category' => 'required|string',
        'product_details' => 'required|string',
        'how_to_use' => 'required|string',
        'shipping_details' => 'required|string',
        'price' => 'required|numeric',
        'weight' => 'required|numeric',
        'qty_of_box' => 'required|integer',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'small_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the product by ID
    $product = Product::findOrFail($id);

    // Update product details
    $product->fill($request->except(['main_image', 'small_images']));

    // Handle main image upload
    if ($request->hasFile('main_image')) {
        // Delete old main image if it exists
        if ($product->main_image) {
            Storage::delete('public/' . $product->main_image);
        }
        $path = $request->file('main_image')->store('products', 'public');
        $product->main_image = $path;
    }

    // Handle small images upload
    if ($request->hasFile('small_images')) {
        $smallImages = json_decode($product->small_images, true) ?? []; // Decode existing small images
        
        foreach ($request->file('small_images') as $index => $image) {
            // Delete the old small image if a new one is uploaded for the same index
            if (isset($smallImages[$index]) && $smallImages[$index]) {
                Storage::delete('public/' . $smallImages[$index]);
            }

            // Store the new image
            $path = $image->store('products', 'public');
            $smallImages[$index] = $path; // Save or update image path
        }

        $product->small_images = json_encode($smallImages); // Store updated small images as JSON
    }

    // Save the updated product
    $product->save();

    // Redirect back to the edit form with a success message
    return redirect()->route('products.index')
        ->with('success', 'Product updated successfully.');
}


    public function destroy($id)
{
    // Find and delete the product
    $product = Product::findOrFail($id);
    $product->delete();

    // Set session message
    return redirect()->route('products.index')
                     ->with('delete_confirmation', 'Product deleted successfully.');
}

    public function deleteImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->image === 'main') {
            // Delete the main image
            if ($product->main_image) {
                Storage::delete('public/' . $product->main_image);
                $product->main_image = null;
                $product->save();
            }
        } else {
            // Delete small image
            $smallImages = json_decode($product->small_images, true) ?? [];

            if (($key = array_search($request->image, $smallImages)) !== false) {
                unset($smallImages[$key]);
                Storage::delete('public/' . $request->image);
                $product->small_images = json_encode(array_values($smallImages));
                $product->save();
            }
        }

        
        return redirect()->route('products.index')
        ->with('success', 'Product deleted successfully.');
    }

    // Method to update an image
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image_type' => 'required|string|in:main,small',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $imageType = $request->image_type;
        $imageFile = $request->file('image');

        if ($imageType === 'main') {
            if ($product->main_image) {
                Storage::delete('public/' . $product->main_image);
            }
            $path = $imageFile->store('products', 'public');
            $product->main_image = $path;
        } else {
            $smallImages = json_decode($product->small_images, true) ?? [];
            if ($imageFile) {
                $path = $imageFile->store('products', 'public');
                $smallImages[] = $path;
                $product->small_images = json_encode($smallImages);
            }
        }

        $product->save();

        return response()->json(['success' => true]);
    }
    
}
