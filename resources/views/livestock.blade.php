@extends('layouts.app')
@section('content')

<div class="container record-container">
    <h2 class="text-center mb-4">LIVESTOCK RECORDS</h2>

    @if($livestocks->isEmpty())
        <div class="alert alert-warning">No livestock records found.</div>
    @else
        @foreach($livestocks as $livestock)
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="owner" class="form-label">Owner:</label>
                    <input type="text" class="form-control" value="{{ $livestock->owner }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="veterinarian" class="form-label">Veterinarian:</label>
                    <input type="text" class="form-control" value="{{ $livestock->veterinarian }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" value="{{ $livestock->name }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="date" class="form-control" value="{{ $livestock->date_of_birth }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="species" class="form-label">Species:</label>
                    <input type="text" class="form-control" value="{{ $livestock->species }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tag" class="form-label">Tag #:</label>
                    <input type="text" class="form-control" value="{{ $livestock->tag }}" readonly>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                @if($livestock->picture)
                    <img src="{{ asset('storage/' . $livestock->picture) }}" alt="Livestock Picture" class="img-fluid" style="max-width: 100%; height: auto;">
                @else
                    <div class="image-placeholder border p-5 text-center" style="width: 100%; height: 250px;">
                        PICTURE NOT AVAILABLE
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    @endif

    <!-- Medical Records Table -->
    <h3>Medical Records</h3>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Treatment</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicals as $medical)
                <tr>
                    <td>{{ $medical->date }}</td>
                    <td>{{ $medical->treatment }}</td>
                    <td>{{ $medical->note }}</td>
                    <td>
                    
                        <a href="{{ route('medicals.edit', $livestock->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('medicals.destroy', $medical->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Vaccination Records Table -->
    <h3>Vaccination Records</h3>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Vaccination</th>
                    <th>Booster</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vaccinations as $vaccination)
                <tr>
                    <td>{{ $vaccination->date }}</td>
                    <td>{{ $vaccination->vaccination }}</td>
                    <td>{{ $vaccination->booster }}</td>
                    <td>
                        {{-- <form action="{{ route('vaccinations.update', $vaccination->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form> --}}
                        <a href="{{ route('vaccinations.edit', $livestock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('vaccinations.destroy', $vaccination->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
