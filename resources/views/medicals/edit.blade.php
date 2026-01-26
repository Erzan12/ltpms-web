@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Edit Medical Records for Livestock: {{ $livestock->name }}</h1>

    <form action="{{ route('medicals.update', $medical->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" class="form-control" name="id" value="{{ Crypt::encrypt($medical->id) }}">

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $medical->date) }}" required>
        </div>

        <div class="mb-3">
            <label for="treatment" class="form-label">Treatment</label>
            <input type="text" class="form-control" id="treatment" name="treatment" value="{{ old('treatment', $medical->treatment) }}" required>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea class="form-control" id="note" name="note" rows="4">{{ old('note', $medical->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Medical Record</button>
    </form>
</div>
@endsection
