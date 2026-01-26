@extends('layouts.app')

@section('content')

<div class="container record-container">
    <h2 class="text-center mb-4">DELETED LIVESTOCK RECORD DETAILS</h2>

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
                    {{-- <td>
                        <a href="{{ route('livestocks.edit', $livestock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('livestocks.destroy', $livestock->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        
                        <a href="{{ route('livestocks.show', $livestock->id) }}" class="btn btn-success btn-sm">View</a>
                    </td> --}}
                </tr>
            @endforeach   
        </tbody>
    </table>
    <!-- Pagination -->
    {{-- <div class="pagination-wrap">
        {{ $livestocks->appends(request()->query())->links('vendor.pagination.custom') }}
    </div> --}}
        
</div>

@endsection
