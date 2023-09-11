@extends('layouts.master')

@section('title')
    Item List
@endsection

@section('content')
    <h4>Item List</h4>

    {{-- @if (request()->has('keyword'))
        [Search result by '{{ request()->keyword }}']
    @endif --}}

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif



    <div class="row justify-content-between mb-3 mt-3">
        <div class="col-md-3">
            <a href="{{ route('item.create') }}" class="btn btn-outline-primary">Create</a>
        </div>

        <div class="col-md-5 w-32">
            <form action="">
                <div class="input-group ">
                    <input type="text" class="form-control" name="keyword"
                        @if (request()->has('keyword')) value="{{ request()->keyword }}" @endif>
                    @if (request()->has('keyword'))
                        <a href="{{ route('item.index') }}" class="btn btn-danger">Clear</a>
                    @endif
                    <button class="btn btn-primary">Search</button>
                </div>



            </form>
        </div>
    </div>

    <div class="alert alert-info">
        {{ route('item.index', ['page' => 2, 'keyword' => 'or', 'name' => 'asc']) }}
    </div>

    <table class="table">

        <thead>
            <tr>
                <td>#</td>
                <td>Name
                    <a class="btn btn-sm btn-outline-primary"
                        href="{{ route('item.index', ['ordering' => 'asc']) }}">ASC</a>
                    <a class="btn btn-sm btn-outline-primary"
                        href="{{ route('item.index', ['ordering' => 'desc']) }}">DESC</a>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('item.index') }}">Clear</a>
                </td>
                <td>Price</td>
                <td>Stock</td>
                <td>Control</td>
            </tr>
        </thead>

        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>

                        <a href="{{ route('item.show', $item->id) }}" class="btn btn-outline-primary">Detail</a>

                        <a href="{{ route('item.edit', $item->id) }}" class="btn btn-outline-info">Edit</a>

                        {{-- can't this because it doesn't UI like edit and html form can't support delete method --}}
                        {{-- <a href="{{ route('item.destroy', $item->id) }}" class="btn btn-outline-danger">Delete</a> --}}


                        <form action="{{ route('item.destroy', $item->id) }}" method="post" class="d-inline-block">
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
                        <a href="{{ route('item.create') }}" class="btn btn-sm btn-primary ">Create Item</a>

                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

    {{ $items->onEachSide(1)->links() }}
@endsection
