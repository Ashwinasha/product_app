@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('delete_confirmation'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('delete_confirmation') }}
        </div>
    @endif

    <!-- Buttons for adding a new product and category management -->
    <div class="d-flex justify-content-end mb-4">
        <div class="d-flex flex-column align-items-end">
            <a href="{{ route('products.create') }}" class="btn btn-custom-primary mb-2 w-100">
                <i class="fas fa-plus me-2"></i> Add New Product
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-custom-secondary w-100">
                Category Management
            </a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-5">
        @foreach($products as $product)
            <div class="col">
                <div class="card card-3d-effect d-flex flex-row position-relative h-100">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div class="image-box">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="No Image Available">
                            @endif
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <p class="card-text">{{ $product->name }}</p>
                            <p class="card-text">{{ $product->category }}</p>
                            <p class="card-text">RS.{{ $product->price }}</p>
                        </div>
                    </div>
                    <div class="position-absolute top-0 end-0 p-2 ">
                        <!-- Edit Icon -->
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-link  p-0 me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i style="color:black;"class="fas fa-pencil-alt"></i>
                        </a>
                        <!-- Delete Icon -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 me-3" onclick="return confirm('Are you sure you want to delete this product?');" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                <i class="fas fa-trash" style="color:black;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4 custom-pagination ">
    {{ $products->links('vendor.pagination.custom-bootstrap') }}
    </div>
</div>
@endsection


