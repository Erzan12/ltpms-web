@extends('layouts.app')

@section('content')

<div class="container record-container">
    <h2 class="text-center mb-4">LIVESTOCK RECORD DETAILS</h2>

    <div class="personal-info row mb-5">
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

        <!-- QR CODE 
        <a href="{{ route('livestock.qr', ['livestock'=> $livestock->id])}}" class="btn btn-secondary">
            Generate QR Code
        </a>
        -->
        <div>
            <!-- Generate qrcode button -->
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#qrCodeModal" data-id="{{ $livestock->id }}">
                Generate QR Code
            </button>

            <!-- qrcode modal -->
            <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrCodeModalLabel"> QR Code for Livestock Tag #: {{ $livestock->tag }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                       <div class="modal-body d-flex justify-content-center align-items-center">
                            <div id="qrCodeImageContainer">
                               <!-- qrcode will be loaded here --> 
                                <p>Generating QR Code...</p>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-primary" onclick="printQrCode()">Print QR Code</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AJAX script for requesting and generating qrcode -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Listen for the modal show event
                    const qrCodeModal = document.getElementById('qrCodeModal');
                    qrCodeModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget; // Button that triggered the modal
                        const livestockId = button.getAttribute('data-id'); // Extract info from data-* attributes

                        // AJAX request to generate the qrcode
                        fetch(`/livestock/${livestockId}/qr`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Load the qrcode image into the modal
                                    document.getElementById('qrCodeImageContainer').innerHTML = `<img src="${data.qrCode}" alt="QR Code" class="img-fluid">`;
                                } else {
                                    document.getElementById('qrCodeImageContainer').innerHTML = '<p>Error generating QR Code.</p>';
                                }
                            })
                            .catch(error => {
                                document.getElementById('qrCodeImageContainer').innerHTML = '<p>Error loading QR Code.</p>';
                            });
                    });
                });
            </script>
        </div>   
    </div>

    <div class="med-vac-rec">
        <a href="{{ route('livestock.medical.create', ['livestock' => $livestock->id]) }}" class="btn btn-primary">
            Add Medical Record
        </a>
        <a href="{{ route('livestock.vaccination.create', ['livestock' => $livestock->id]) }}" class="btn btn-primary">
            Add Vaccination Record
        </a>
    </div>

    <!-- Medical Records Table -->
    <h3>Medical Records</h3>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Treatment</th>
                    <th>Notes</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($medicals as $medical)
                <tr>
                    <td>{{ $medical->date }}</td>
                    <td>{{ $medical->treatment }}</td>
                    <td>{{ $medical->note }}</td>
                    <td>
                        <a href="{{ route('medicals.edit', $medical->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#delete-{{$medical->id}}">delete</button>
                        
                    </td>
                </tr>
                {{-- modal delete confirmation --}}
                <div class="modal fade" id="delete-{{$medical->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">Delete Medical Record?</h3>
                            <form action="{{ route('medicals.destroy', $medical->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
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
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($vaccinations as $vaccination)
                <tr>
                    <td>{{ $vaccination->date }}</td>
                    <td>{{ $vaccination->vaccination }}</td>
                    <td>{{ $vaccination->booster }}</td>
                    <td>
                        <a href="{{ route('vaccinations.edit', $vaccination->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                        
                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#delete-{{$vaccination->id}}" data-bs->Delete</button>
                        
                    </td>
                </tr>
                {{-- modal delete confirmation --}}
                <div class="modal fade" id="delete-{{$vaccination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">Delete Vaccination Record?</h3>
                            <form action="{{ route('vaccinations.destroy', $vaccination->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
