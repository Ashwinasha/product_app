@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <h4 class="breadcrumb">Product Management > Add Categories</h4>
    <div class="d-flex justify-content-center mt-5">
        <div class="category-card card shadow-sm">
            <div class="container mt-3">
            <div class="card-body d-flex flex-column position-relative">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-grow-1">
                    @csrf
                    <div class="row align-items-start flex-grow-1">
                        <!-- Upload Image -->
                        <div class="col-12 col-md-4 d-flex flex-column align-items-center mb-3 mb-md-0">
                            <div class="category-upload-text">Upload Image</div>
                            <div class="category-upload-container">
                                <input type="file" id="category_image" name="category_image" class="category-upload-input">
                                <div class="category-upload-icon">+</div>
                                <img id="category_image_preview" src="" alt="Image Preview" class="category-upload-preview">
                            </div>
                        </div>

                        <!-- Category Name -->
                        <div class="col-12 col-md-8">
                            <div class="category-form-group">
                                <label for="category_name" class="category-name-label">Category Name</label>
                                <input type="text" class="category-form-control form-control" id="category_name" name="category_name" placeholder="Category name">
                            </div>
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="category-save-btn-container">
                        <button type="submit" style="padding: 4px 25px;"class=category-save-btn btn btn-dark">Save</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="{{ asset('css/category_style.css') }}">
@endsection





