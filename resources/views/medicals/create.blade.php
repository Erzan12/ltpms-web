@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Medical Record</h2>

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

    <form action="{{ route('medicals.store') }}" method="POST">
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
            <label for="treatment">Treatment</label>
            <input type="text" class="form-control @error('treatment') is-invalid @enderror" id="treatment" name="treatment" value="{{ old('treatment') }}" required>
            @error('treatment')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Note -->
        <div class="form-group">
            <label for="note">Note</label>
            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="4" required>{{ old('note') }}</textarea>
            @error('note')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Medical Record</button>
    </form>
</div>
@endsection
