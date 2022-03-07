@extends('layout.main')
@section('title')
    Product Create
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h2>Laravel Crud Operation</h2>
                <a href="{{ route('product.index') }}" class="btn btn-success float-right">Go To Product List</a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" placeholder="Enter product name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="description" style="width: 100%;">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Upload Product Image</label>
                    <input type="file" class="form-control" name="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-success mx-auto">Save Product</button>
                </div>
            </form>
        </div>
    </div>
@endsection
