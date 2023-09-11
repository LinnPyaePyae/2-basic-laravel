@extends('layouts.master')

@section('title')
    Home Page
@endsection

@section('content')
    <h4>I'm Home</h4>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Odio rerum ad ducimus ea magni, incidunt unde, autem
        commodi blanditiis libero laborum, quas laudantium quis quod praesentium deleniti temporibus adipisci. Eius.</p>

    <div class="alert alert-info">

        {{-- {{ route('item.show', [15, 'a' => 'aaa', 'b' => 'bbb']) }}
         --}}

        {{ route('multi', [5, 15, 'page' => 2, 'sort' => 10]) }}
    </div>
@endsection
