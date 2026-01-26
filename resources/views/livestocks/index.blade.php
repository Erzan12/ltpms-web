@extends('layouts.app')
@section('content')

<h1 class="listing mb-4 text-center">Livestock Management List</h1>
        
    <div class="container">
        <!-- Filter Form -->
         <div class="form-filter align-items-center">
            <form method="GET" action="{{ route('livestocks.index') }}">
                <div class="row mb-4">
                <div class="col-md-4 mt-2">
                    <input type="text" name="owner" class="form-control" placeholder="Filter by Owner" value="{{ request('owner') }}">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="species" class="form-control" placeholder="Filter by Species" value="{{ request('species') }}">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="veterinarian" class="form-control" placeholder="Filter by Veterinarian" value="{{ request('veterinarian') }}">
                </div>
                <div class="col-md-4 mt-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                </div>
            </form>
         </div>
        <!-- Filter results counter -->
                @if($livestocks->count())
                <p>{{ $livestocks->count() }} records found</p>
                @else
                <p>No records found</p>
                @endif
        {{-- add button --}}
        
        <div class="d-flex justify-content-end">
            <a href="/livestocks/create" class="btn btn-primary mb-3">Add Livestock</a>
            <a href="/livestocks/showdeleted" class="btn btn-secondary mb-3">View Deleted Livestocks</a>
        </div>
                <!-- Livestock Table -->
        <table class="table table-wrap table-striped table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Owner</th>
                    <th>Veterinarian</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Species</th>
                    <th>Tag Number</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($livestocks as $livestock)
                    <tr>
                        <td>{{ $livestock->id }}</td>
                        <td>{{ $livestock->owner }}</td>
                        <td>{{ $livestock->veterinarian }}</td>
                        <td>{{ $livestock->name }}</td>
                        <td>{{ $livestock->date_of_birth }}</td>
                        <td>{{ $livestock->species }}</td>
                        <td>{{ $livestock->tag }}</td>
                        <td>
                            {{-- {{$livestock->picture}} --}}
                            <img src="{{asset('storage/'.$livestock->picture)}}" alt="{{$livestock->picture}}" style="width: 100%; max-width: 150px; aspect-ratio: 2/1;">
                        </td>
                        <td>
                            <a href="{{ route('livestocks.edit', $livestock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('livestocks.destroy', $livestock->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            
                            <a href="{{ route('livestocks.show', $livestock->id) }}" class="btn btn-success btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach   
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="pagination-wrap">
            {{ $livestocks->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
        <!-- Deletion Warning -->
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this livestock entry? This action cannot be undone.');
            }
        </script>
    </div>
@endsection
