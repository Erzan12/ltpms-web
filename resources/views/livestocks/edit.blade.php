@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Livestock</h1>

    <form action="{{ route('livestocks.update', $livestock->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="owner" class="form-label">Owner</label>
            <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner', $livestock->owner) }}" required>
        </div>
        <div class="mb-3">
            <label for="veterinarian" class="form-label">Veterinarian</label>
            <input type="text" class="form-control" id="veterinarian" name="veterinarian" value="{{ old('veterinarian', $livestock->veterinarian) }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $livestock->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $livestock->date_of_birth) }}" required>
        </div>
        <div class="mb-3">
            <label for="species" class="form-label">Species</label>
            <input type="text" class="form-control" id="species" name="species" value="{{ old('species', $livestock->species) }}" required>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Picture</label>
            <input type="file" class="form-control" id="picture" name="picture">
        </div>

        <button type="submit" class="btn btn-primary">Update Livestock</button>
    </form>
</div>
@endsection
