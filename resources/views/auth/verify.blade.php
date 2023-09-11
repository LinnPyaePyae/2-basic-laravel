@extends('layouts.master')

@section('title')
    Change Password
@endsection

@section('content')
    <h4>Verify </h4>

    <hr>

    <form action="{{ route('auth.verifying') }}" method="post">

        @csrf



        <div class="mb-3">
            <label class=" form-label" for="">Verify Code</label>
            <input type="number" class=" form-control @error('verify_code') is-invalid @enderror" name="verify_code"
                value="{{ old('verify_code') }}">
            @error('verify_code')
                <div class=" invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button class=" btn btn-primary">Verify Account </button>
        </div>


    </form>
@endsection
