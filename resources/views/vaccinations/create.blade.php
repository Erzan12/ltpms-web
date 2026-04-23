@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Vaccination Record</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vaccinations.store') }}" method="POST">
        @csrf

        <!-- Livestock ID (hidden field) -->
        <input type="hidden" name="livestock_id" value="{{ $livestock_id }}">

        <!-- Date -->
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Treatment -->
        <div class="form-group">
            <label for="vaccination">Vaccination</label>
            <input type="text" class="form-control @error('vaccination') is-invalid @enderror" id="vaccination" name="vaccination" value="{{ old('vaccination') }}" required>
            @error('vaccination')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Note -->
        <div class="form-group">
            <label for="booster">Booster</label>
            <textarea class="form-control @error('booster') is-invalid @enderror" id="booster" name="booster" rows="4" required>{{ old('booster') }}</textarea>
            @error('booster')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Vaccination Record</button>
    </form>
</div>
@endsection
