<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use App\Models\LetterofAcceptance;
use Illuminate\Support\Facades\Storage;

class LetterofAcceptanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['LetterofAcceptance' => LetterofAcceptance::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'author_name' => 'required',
            'institution' => 'required',
            'email' => 'required',
            'conference_title' => 'required|string',
            'paper_id' => 'required|string|unique:letter_of_acceptances,paper_id',
            'paper_title' => 'required|string',
            'issued_at' => 'required|string',
            'status' => 'required|in:Accepted,Rejected',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $validatedData['signature'] = $path;
        }
    
        $loa = LetterofAcceptance::create($validatedData);
    
        return response()->json($loa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $paper_id)
    {
        $loa = LetterofAcceptance::where('paper_id', $paper_id)->first();
        if (!$loa) {
            return response()->json(['message' => 'Letter Of Acceptance not found'], 404);
        }
        return response()->json($loa, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loa = LetterofAcceptance::find($id);
        if (!$loa) {
            return response()->json(['message' => 'Letter Of Acceptance not found'], 404);
        }
    
        $validatedData = $request->validate([
            'author_name' => 'required',
            'institution' => 'required',
            'email' => 'required',
            'conference_title' => 'required|string',
            'paper_id' => [
                'required',
                'string',
                Rule::unique('letter_of_acceptances', 'paper_id')->ignore($loa->id),
            ],
            'paper_title' => 'required|string',
            'issued_at' => 'required|string',
            'status' => 'required|in:Accepted,Rejected',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('signature')) {
            // Hapus signature lama jika ada
            if ($loa->signature) {
                Storage::disk('public')->delete($loa->signature);
            }
            $path = $request->file('signature')->store('signatures', 'public');
            $validatedData['signature'] = $path;
        }
    
        $loa->update($validatedData);
    
        return response()->json($loa, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loa = LetterofAcceptance::find($id);
        if (!$loa) {
            return response()->json(['message' => 'Letter Of Acceptance not found'], 404);
        }

        $loa->delete();
        return response()->json(['message' => 'Letter Of Acceptance deleted'], 200);
    }

    /**
     * Returns the specified resource from storage.
     */
    public function restore(string $id)
    {
        $loa = LetterofAcceptance::onlyTrashed()->find($id);
        if (!$loa) {
            return response()->json(['message' => 'Letter Of Acceptance not found'], 404);
        }
    
        $loa->restore();
        return response()->json(['message' => 'Letter Of Acceptance restored'], 200);
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete(string $id)
    {
        $loa = LetterofAcceptance::onlyTrashed()->find($id);
        if (!$loa) {
            return response()->json(['message' => 'Letter Of Acceptance not found'], 404);
        }

        if ($loa->signature) {
            Storage::disk('public')->delete($loa->signature);
        }
    
        $loa->forceDelete();
        return response()->json(['message' => 'Letter Of Acceptance permanently deleted'], 200);
    }

    /**
     * Download the specified resource from storage.
     */
    public function downloadPDF($paper_id)
    {
        $loa = LetterofAcceptance::where('paper_id', $paper_id)->first();

        if (!$loa) {
            return response()->json(['message' => 'Letter Of Acceptance not found'], 404);
        }

        // Load tampilan PDF dengan data LOA
        $pdf = Pdf::loadView('pdf.letter_of_acceptance', compact('loa'));

        // Download file PDF dengan nama sesuai paper_id
        return $pdf->download("Letter_of_Acceptance_{$loa->paper_id}.pdf");
    }

}
