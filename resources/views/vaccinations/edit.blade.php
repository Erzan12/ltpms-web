@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{$message}}</div>
    @endif
    <h1>Edit Vaccination Records for Livestock: {{ $livestock->name }}</h1>

    <form action="{{ route('vaccinations.update', $vaccination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" class="form-control" name="id" value="{{Crypt::encrypt($vaccination->id)}}">
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $vaccination->date) }}" required>
        </div>
        <div class="mb-3">
            <label for="vaccination" class="form-label">Vaccination</label>
            <input type="text" class="form-control" id="vaccination" name="vaccination" value="{{ old('vaccination', $vaccination->vaccination) }}" required>
        </div>
        <div class="mb-3">
            <label for="booster" class="form-label">Booster</label>
            <input type="text" class="form-control" id="booster" name="booster" value="{{ old('booster', $vaccination->booster) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Record</button>
    </form>
</div>
@endsection
