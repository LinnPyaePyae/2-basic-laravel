@extends('layouts.master')

@section('title')
    Dashboard Home
@endsection

@section('content')
    <h4>I'm Dashboad Home</h4>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi iure praesentium accusamus dicta magni adipisci
        molestias nemo tempora ipsum odio dolores, voluptas quo debitis id corporis rem, vitae quaerat nostrum.
    </p>

    <div class=" alert alert-info">
        {{ session('auth')->name }}
    </div>

    <form action="{{ route('auth.logout') }}" method="post">
        @csrf
        <button class=" btn btn-primary">Logout</button>
    </form>
@endsection
