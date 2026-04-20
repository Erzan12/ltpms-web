<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medical;
use App\Models\Vaccination;
use App\Models\Livestock;
use Illuminate\Support\Facades\Crypt;

class MedicalRecordController extends Controller
{
    public function create($livestockId)
    {
        return view('medicals.create', [
            'livestock' => $livestock,
            'livestock_id' => $livestockId
        ]);
    }

    public function index()
    {
        // Retrieve all medical records
        $medicals = Medical::all();
        
        // Retrieve all livestock records
        $livestocks = Livestock::all(); 

        // Retrieve all vaccination records
        $vaccinations = Vaccination::all();
        
        // Return both medical and livestock data to the view
        return view('livestock', compact('medicals', 'livestocks', 'vaccinations'));
    }

    public function records($id) {
        return response()->json(
            Medical::where("livestock_id", $id)->latest()->get()
            ->transform(function($record) {
                return [
                    "id" => $record->id,
                    "treatment" => $record->treatment,
                    "note" => $record->note,
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

    public function store(Request $request, Medical $medicals)
    {
        $validatedData = $request->validate([
            'date' => 'required|string',
            'treatment' => 'required|string',
            'note' => 'required|string',
            'livestock_id' => 'required|exists:livestocks,id',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        // Save to the original database
        $medical = Medical::create($validatedData);

        // Ensure the livestock record exists in the backup database
        $livestock = Livestock::findOrFail($validatedData['livestock_id']);
        $backupLivestock = \DB::connection('mysql_backup')->table('livestocks')
                            ->where('id', $livestock->id)
                            ->first();

        if (!$backupLivestock) {
            // Insert the livestock record into the backup database if it doesn't exist
            \DB::connection('mysql_backup')->table('livestocks')->insert([
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

        // Now, insert the medical record into the backup database
        // \DB::connection('mysql_backup')->table('medicals')->insert([
        //     'date' => $validatedData['date'],
        //     'treatment' => $validatedData['treatment'],
        //     'note' => $validatedData['note'],
        //     'livestock_id' => $validatedData['livestock_id'],
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return redirect()->route('livestocks.show', ['livestock' => $request->livestock_id])
                        ->with('success', 'Medical record added successfully.');
    }

    public function edit($id)
    {
        $medical = Medical::findOrFail($id);
        $livestock = Livestock::findOrFail($medical->livestock_id);
        return view('medicals.edit', compact('medical', 'livestock'));
    }
    
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'date' => 'required|string',
            'treatment' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $id = Crypt::decrypt($request->id);
        $medical = Medical::findOrFail($id);

        $livestockId = $medical->livestock_id;

        // Update in the original database
        $medical->update($validatedData);

        //Update in the backup database
        \DB::connection('mysql_backup')->table('medicals')
            ->where('id', $id)
            ->update(array_merge($validatedData, ['updated_at' => now()]));

        return redirect()->route('livestocks.show', ['livestock' => $livestockId])
                         ->with('success', 'Medical record updated successfully.');
    }


    public function destroy(Request $request, Medical $medical)
    {           
        $medical = $medical::findOrFail($request->id); 
        $livestockId = $medical->livestock_id;
        $medical->delete();
        
        return redirect()->route('livestocks.show', ['livestock' => $livestockId])
                         ->with('success', 'Medical record deleted successfully.');
    }

    //api
    public function apiStore(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|string',
            'treatment' => 'required|string',
            'note' => 'required|string',
            'livestock_id' => 'required|exists:livestocks,id'
        ]);

        $medical = Medical::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Medical record added successfully.',
            'data' => $medical
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|string',
            'treatment' => 'required|string',
            'note' => 'nullable|string'
        ]);

        $medical = Medical::findOrFail($id);
        $medical->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Medical record updated successfully.',
            'data' => $medical
        ], 200);
    }

}
