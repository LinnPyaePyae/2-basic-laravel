@extends('layouts.master')

@section('title')
    Category List
@endsection

@section('content')
    <h4>Category List</h4>
    <table class="table">

        <thead>
            <tr>
                <td>#</td>
                <td>Title</td>
                <td>Description</td>
                <td>Control</td>

            </tr>
        </thead>


        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->title }}</td>
                    <td>{{ Str::limit($category->description, 20, '...') }}</td>

                    <td>
                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-outline-primary">Detail</a>

                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-outline-info">Edit</a>

                        <form action="{{ route('category.destroy', $category->id) }}" method="post" class="d-inline-block">
                            @method('delete')
                            @csrf
                            <button class="btn btn-outline-danger">Delete</button>
                        </form>


                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="5">
                        There is no record<br />
                        <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary ">Create Item</a>

                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
@endsection
