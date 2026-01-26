@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Livestock</h1>
    
    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('livestocks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="owner" class="form-label">Owner</label>
            <input type="text" name="owner" class="form-control" id="owner" value="{{ old('owner') }}" required>
        </div>
        <div class="mb-3">
            <label for="veterinarian" class="form-label">Veterinarian</label>
            <input type="text" name="veterinarian" class="form-control" id="veterinarian" value="{{ old('veterinarian') }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="{{ old('date_of_birth') }}" required>
        </div>
        <div class="mb-3">
            <label for="species" class="form-label">Species</label>
            <input type="text" name="species" class="form-control" id="species" value="{{ old('species') }}" required>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Picture</label>
            <input type="file" name="picture" class="form-control" id="picture" required accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
