@extends('layouts.master')

@section('title')
    Category Edit
@endsection

@section('content')
    <h4>Category Edit</h4>

    <form action="{{ route('category.update', $category->id) }}" method="post">

        @method('put')

        @csrf

        <div class="mb-3">
            <label for="" class="form-label">Category Title</label>
            <input type="text" class="form-control" value="{{ $category->title }}" name="title">
        </div>



        <div class="mb-3">
            <label for="" class="form-label">Category Description</label>
            <input type="text" class="form-control" value="{{ $category->description }}" name="description">
        </div>



        <button class="btn btn-primary">Update Category</button>

    </form>
@endsection
