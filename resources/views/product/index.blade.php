@extends('layout.main')
@section('title')
    Product Lists
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h2>Laravel Crud Operation</h2>
                <a href="{{ route('product.create') }}" class="btn btn-success btn-sm float-right">Add New Product</a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ ++$id }}</th>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ asset('images/products/' . $product->image) }}" style="width:100px;" alt="">
                            </td>
                            <td>
                                <div class="d-inline-flex">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger ml-2">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
