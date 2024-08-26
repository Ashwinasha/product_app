@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h4 class="mb-4">Product Management > Edit Product</h4>
    
    <!-- Centered Form Container -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="form-container p-4 bg-white rounded shadow-lg mb-5">
                
                <!-- Display Success or Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Information Fields -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="model_number" class="form-label">Model Number</label>
                        <input type="text" class="form-control" id="model_number" name="model_number" value="{{ old('model_number', $product->model_number) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Categories</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" disabled>Select a category</option>
                            <option value="Category 1" {{ old('category', $product->category) === 'Category 1' ? 'selected' : '' }}>Category 1</option>
                            <option value="Category 2" {{ old('category', $product->category) === 'Category 2' ? 'selected' : '' }}>Category 2</option>
                            <!-- More categories -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <div>
                            <div class="form-check form-check-inline me-5">
                                <input class="form-check-input" type="radio" name="availability" id="inStock" value="in_stock" {{ old('availability', $product->availability) === 'in_stock' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="inStock">In Stock</label>
                            </div>
                            <div class="form-check form-check-inline ms-5">
                                <input class="form-check-input" type="radio" name="availability" id="outOfStock" value="out_of_stock" {{ old('availability', $product->availability) === 'out_of_stock' ? 'checked' : '' }}>
                                <label class="form-check-label" for="outOfStock">Out of Stock</label>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="product_details" class="form-label">Product Details</label>
                        <textarea class="form-control" id="product_details" name="product_details" rows="3" required>{{ old('product_details', $product->product_details) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="how_to_use" class="form-label">How to Use</label>
                        <textarea class="form-control" id="how_to_use" name="how_to_use" rows="3" required>{{ old('how_to_use', $product->how_to_use) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_details" class="form-label">Shipping Details</label>
                        <textarea class="form-control" id="shipping_details" name="shipping_details" rows="3" required>{{ old('shipping_details', $product->shipping_details) }}</textarea>
                    </div>

                    <!-- Pricing and Quantity Fields -->
                    <table class="table mb-3">
                        <thead>
                            <tr>
                                <th>Price</th>
                                <th>Weight</th>
                                <th>QTY of a box</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="number" class="form-control" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="weight" step="0.01" value="{{ old('weight', $product->weight) }}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="qty_of_box" value="{{ old('qty_of_box', $product->qty_of_box) }}" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mb-3">
                        <button type="button" id="add-row" class="btn btn-secondary w-100">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    
                    <div class="container mt-5">
                        <div class="row">
                            <!-- Main Image Upload -->
                            <div class="col-md-8 d-flex justify-content-center">
                                <div class=" main-upload d-flex justify-content-center align-items-center">
                                    @if($product->main_image)
                                    <img id="mainImagePreview" src="{{ asset('storage/products/5lTN4gCpU86KJjI4Lpwfg7ba3LeTeimHNn30oNzC.jpg') }}" alt="Main Image Preview" style="max-width: 100%;" />

                                    @else
                                        <img id="mainImagePreview" alt="Main Image Preview" style="display: none;" />
                                    @endif
                                    <input type="file" name="main_image" id="mainImage" style="display: none;" />
                                    <button class="upload-icon btn" type="button" onclick="document.getElementById('mainImage').click();">+</button>
                                </div>
                            </div>

                            <!-- Small Image Uploads -->
                            <div class="col-md-4">
                                <div class="row">
                                    @foreach($product->small_images as $index => $image)
                                        <div class="col-12 mb-2 d-flex justify-content-center">
                                            <div class=" small-upload d-flex justify-content-center align-items-center">
                                                <img id="smallImagePreview{{ $index }}" src="{{ asset('storage/products/' . $image) }}" alt="Small Image Preview" style="max-width: 100%;" />
                                                <input type="file" name="small_images[]" id="smallImage{{ $index }}" style="display: none;" />
                                                <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImage{{ $index }}').click();">+</button>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Placeholder for additional small images -->
                                    <div class="col-12 mb-2 d-flex justify-content-center">
                                        <div class=" small-upload d-flex justify-content-center align-items-center">
                                            <img id="smallImagePreviewNew" src="" alt="Small Image Preview" style="max-width: 100%; display: none;" />
                                            <input type="file" name="small_images[]" id="smallImageNew" style="display: none;" />
                                            <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImageNew').click();">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 d-flex justify-content-center">
                                        <div class=" small-upload d-flex justify-content-center align-items-center">
                                            <img id="smallImagePreviewNew" src="" alt="Small Image Preview" style="max-width: 100%; display: none;" />
                                            <input type="file" name="small_images[]" id="smallImageNew" style="display: none;" />
                                            <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImageNew').click();">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 d-flex justify-content-center">
                                        <div class=" small-upload d-flex justify-content-center align-items-center">
                                            <img id="smallImagePreviewNew" src="" alt="Small Image Preview" style="max-width: 100%; display: none;" />
                                            <input type="file" name="small_images[]" id="smallImageNew" style="display: none;" />
                                            <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImageNew').click();">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
