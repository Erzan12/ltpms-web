<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use Illuminate\Http\Request;
use App\Models\Medical;
use App\Models\Vaccination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LivestockController extends Controller
{
    public function index(Request $request)
    {
        // Build the query with filters
        $query = Livestock::query();

        // Filter by owner if provided
        if ($request->has('owner') && $request->owner !== null) {
            $query->where('owner', 'like', '%' . $request->input('owner') . '%');
        }

        // Filter by species if provided
        if ($request->has('species') && $request->species !== null) {
            $query->where('species', 'like', '%' . $request->input('species') . '%');
        }

        // Filter by veterinarian if provided
        if ($request->has('veterinarian') && $request->veterinarian !== null) {
            $query->where('veterinarian', 'like', '%' . $request->input('veterinarian') . '%');
        }
        
        // Paginate the results
        $livestocks = $query->paginate(10);

        // Pass the data to the view
        return view('livestocks.index', compact('livestocks'));
    }

    //API get livestocks
    public function getLivestocks(Request $request) {
        // Build the query with filters
        $query = Livestock::query();

        // Filter by owner if provided
        if ($request->has('owner') && $request->owner !== null) {
            $query->where('owner', 'like', '%' . $request->input('owner') . '%');
        }

        // Filter by species if provided
        if ($request->has('species') && $request->species !== null) {
            $query->where('species', 'like', '%' . $request->input('species') . '%');
        }

        // Filter by veterinarian if provided
        if ($request->has('veterinarian') && $request->veterinarian !== null) {
            $query->where('veterinarian', 'like', '%' . $request->input('veterinarian') . '%');
        }

        return response()->json([
            "data" => $query->get(["id", "owner", "name", "veterinarian", "date_of_birth", "species", "picture", "tag"])
        ], 200);
    }

    public function create()
    {
        // Return the view to create a new livestock record
        return view('livestocks.create');
    }
    
    public function show($id)
    {
    // Find the specific livestock by ID
    $livestock = Livestock::findOrFail($id);

    // Retrieve related medical and vaccination records
    $medicals = Medical::where('livestock_id', $id)->get();
    $vaccinations = Vaccination::where('livestock_id', $id)->get();

    // Pass the data to the view
    return view('livestocks.show', compact('livestock', 'medicals', 'vaccinations'));
    }

    public function showdeleted()
{
    // Retrieve only soft-deleted records
    $livestocks = Livestock::onlyTrashed()->get();

    // Pass the data to the view
    return view('livestocks.showdeleted', compact('livestocks'));
}

    public function getLivestockByQrCode(Request $request)
    {
        $qrCodeHash = $request->input('qr-code');

        
        $livestock = Livestock::where('tag', $qrCodeHash)->get(["id", "owner", "name", "veterinarian", "date_of_birth", "species", "picture", "tag"]);

        if ($livestock->isNotEmpty()) {
            // Generate public image URL
            // $imageUrl = asset('storage/' . $livestock->image);

            return response()->json([
                "data" => $livestock->first()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Livestock not found'
            ], 404);
        }
    }



    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'owner' => 'required|string',
            'veterinarian' => 'required|string',
            'name' => 'required|string',
            'date_of_birth' => 'required|date',
            'species' => 'required|string',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Generate a random string for Tag Number
        do {
            $tagNumber = 'TAG-' . strtoupper(Str::random(8));
        } while (Livestock::where('tag', $tagNumber)->exists());

        // Save the picture to storage
        $picturePath = $request->file('picture')->store('livestock_pictures', 'public');

        // Save the livestock data
        $livestock = Livestock::create([
            'owner' => $validatedData['owner'],
            'veterinarian' => $validatedData['veterinarian'],
            'name' => $validatedData['name'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'species' => $validatedData['species'],
            'tag' => $tagNumber,
            'picture' => $picturePath,
        ]);

        // $file = move(public_path('livestock_picture'), '');

        // Return success message and redirect to /livestocks
        // \DB::connection('mysql_backup')->table('livestocks')->insert([
        //     'owner' => $validatedData['owner'],
        //     'veterinarian' => $validatedData['veterinarian'],
        //     'name' => $validatedData['name'],
        //     'date_of_birth' => $validatedData['date_of_birth'],
        //     'species' => $validatedData['species'],
        //     'tag' => $tagNumber,
        //     'picture' => $picturePath,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        return redirect()->route('livestocks.index')
                         ->with('success', 'Livestock record created successfully.');
    }

    public function edit($id)
    {
        // Find the livestock by ID
        $livestock = Livestock::findOrFail($id);

        // Return the edit view with the livestock data
        return view('livestocks.edit', compact('livestock'));
        // Fetch all medical records and vaccinations from the database
        $medicals = Medical::all();
        $vaccinations = Vaccination::all();
        $livestocks = Livestock::all();


        // Pass both variables to the view
        return view('livestock', compact('vaccinations', 'medicals','livestocks'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'owner' => 'required|string',
            'veterinarian' => 'required|string',
            'name' => 'required|string',
            'date_of_birth' => 'required|date',
            'species' => 'required|string',
            'picture' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Find the livestock by ID
        $livestock = Livestock::findOrFail($id);

        // Update the livestock data in the original database
        $livestock->update($validatedData);

        // Handle picture update if a new picture is uploaded
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('livestock_pictures', 'public');
            $livestock->update(['picture' => $path]);
            $validatedData['picture'] = $path;
        }

        // Update the livestock data in the backup database
        // \DB::connection('mysql_backup')->table('livestocks')
        //     ->where('id', $id)
        //     ->update(array_merge($validatedData, ['updated_at' => now()]));

        // Redirect with a success message
        return redirect()->route('livestocks.index')->with('success', 'Livestock updated successfully in both databases!');
    }


    public function destroy($id)
    {
        // Find the livestock by ID and delete it
        $livestock = Livestock::findOrFail($id);
        $livestock->delete();

        // Redirect with a success message
        return redirect()->route('livestocks.index')->with('success', 'Livestock deleted successfully!');
    }
    

    
}
