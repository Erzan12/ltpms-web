<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaccination;
use App\Models\Medical;
use App\Models\Livestock;
use Illuminate\Support\Facades\Crypt;


class VaccinationController extends Controller
{
    public function create($livestockId)
    {
        $livestock = Livestock::findOrFail($livestockId);

        // Pass the livestock_id to the view
        return view('vaccinations.create', [
            'livestock' => $livestock,
            'livestock_id' => $livestockId
        ]);
    }
    public function index()
    {
        // Retrieve all medical records
        $medicals = Medical::all();
        
        // Retrieve all vaccination records
        $vaccinations = Vaccination::all();
        
        // Retrieve all livestock records
        $livestocks = Livestock::all(); 
        
        // Return both medical, vaccination, and livestock data to the view
        return view('livestock', compact('medicals', 'vaccinations', 'livestocks'));
    }

    public function records($id) {
        return response()->json(
            Vaccination::where("livestock_id", $id)->latest()->get()
            ->transform(function($record) {
                return [
                    "id" => $record->id,
                    "vaccination" => $record->vaccination,
                    "booster" => $record->booster,
                    "date" => $record->date,
                ];
            })
        );
    }

    public function show($id)
    {
        // Find the specific livestock
        $livestock = Livestock::findOrFail($id);

        // Retrieve medical and vaccination records related to this livestock
        $medicals = Medical::where('livestock_id', $id)->get();
        $vaccinations = Vaccination::where('livestock_id', $id)->get();

        // Pass the data to the view
        return view('livestocks.show', compact('livestock', 'medicals', 'vaccinations'));
    }

    public function store(Request $request, Vaccination $vaccinations)
    {
        $validatedData = $request->validate([
            'date' => 'required|string',
            'vaccination' => 'required|string',
            'booster' => 'required|string',
            'livestock_id' => 'required|exists:livestocks,id',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        // Save to the original database
        $vaccinations = Vaccination::create($validatedData);

        // Ensure the livestock record exists in the backup database
        $livestock = Livestock::findOrFail($validatedData['livestock_id']);
        $backupLivestock = \DB::connection('pgsql_backup')->table('livestocks')
                            ->where('id', $livestock->id)
                            ->first();

        if (!$backupLivestock) {
            // Insert the livestock record into the backup database if it doesn't exist
            \DB::connection('pgsql_backup')->table('livestocks')->insert([
                'id' => $livestock->id,
                'owner' => $livestock->owner,
                'veterinarian' => $livestock->veterinarian,
                'name' => $livestock->name,
                'date_of_birth' => $livestock->date_of_birth,
                'species' => $livestock->species,
                'tag' => $livestock->tag,
                'picture' => $livestock->picture,
                'created_at' => $livestock->created_at,
                'updated_at' => $livestock->updated_at,
            ]);
        }

        // Now, insert the vaccination record into the backup database
        \DB::connection('pgsql_backup')->table('vaccinations')->insert([
            'date'         => $validatedData['date'],
            'vaccination'  => $validatedData['vaccination'],
            'booster'      => $validatedData['booster'],
            'livestock_id' => $validatedData['livestock_id'],
            'user_id'      => $validatedData['user_id'],
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('livestocks.show', ['livestock' => $request->livestock_id])
                        ->with('success', 'Vaccination record added successfully.');
    }

    public function edit($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        $livestock = Livestock::findOrFail($vaccination->livestock_id);
        return view('vaccinations.edit', compact('vaccination', 'livestock'));
    }
    
    public function update(Request $request, Vaccination $vaccination)
    {    
        $validatedData = $request->validate([
            'id' => 'required|string',
            'date' => 'required|date',
            'vaccination' => 'required|string',
            'booster' => 'nullable|string',
        ]);

        $id = Crypt::decrypt($request->id);
        $vaccination = Vaccination::findOrFail($id);

        // Update vaccination record fields
        $vaccination->date = $validatedData['date'];
        $vaccination->vaccination = $validatedData['vaccination'];
        $vaccination->booster = $validatedData['booster'];
        $vaccination->updated_at = now()->format('Y-m-d H:i:s');

        $vaccination->save();

        // Redirect back to the livestock details page
        return redirect()->route('livestocks.show', ['livestock' => $vaccination->livestock_id])
                        ->with('success', 'vaccination record updated successfully.');
    }

    public function destroy(Request $request)
    {
        $vaccination_row = Vaccination::findOrFail($request->id);
        $livestockId = $vaccination_row->livestock_id; 
        $vaccination_row->delete();

        return redirect()->route('livestocks.show', ['livestock' => $livestockId])
                        ->with('success', 'Vaccination record deleted successfully.');
    }
    //api
    public function apiStore(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|string',
            'vaccination' => 'required|string',
            'booster' => 'required|string',
            'livestock_id' => 'required|exists:livestocks,id'
        ]);

        $vaccination = Vaccination::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Vaccination record added successfully.',
            'data' => $vaccination
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'vaccination' => 'required|string',
            'booster' => 'nullable|string'
        ]);

        $vaccination = Vaccination::findOrFail($id);
        $vaccination->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Vaccination record updated successfully.',
            'data' => $vaccination
        ], 200);
    }
}

