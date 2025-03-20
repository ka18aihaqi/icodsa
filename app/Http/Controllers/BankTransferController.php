<?php

namespace App\Http\Controllers;

use App\Models\BankTransfer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BankTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['BankTransfers' => BankTransfer::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bank_name' => 'required|string',
            'swift_code' => 'nullable|string',
            'recipient_name' => 'required|string',
            'beneficiary_account_number' => 'required|string|unique:bank_transfers,beneficiary_account_number',
            'bank_branch' => 'nullable|string',
            'bank_address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
        ]);
    
        $BankTransfer = BankTransfer::create($validatedData);
    
        return response()->json($BankTransfer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bankTransfer = BankTransfer::where('id', $id)->first();
        if (!$bankTransfer) {
            return response()->json(['message' => 'Bank not found'], 404);
        }
        return response()->json($bankTransfer, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bankTransfer = BankTransfer::find($id);
        if (!$bankTransfer) {
            return response()->json(['message' => 'Bank not found'], 404);
        }
    
        $validatedData = $request->validate([
            'bank_name' => 'required|string',
            'swift_code' => 'nullable|string',
            'recipient_name' => 'required|string',
            'beneficiary_account_number' => [
                'required',
                'string',
                Rule::unique('bank_transfers', 'beneficiary_account_number')->ignore($bankTransfer->id),
            ],
            'bank_branch' => 'nullable|string',
            'bank_address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
        ]);
    
        $bankTransfer->update($validatedData);
    
        return response()->json($bankTransfer, 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bankTransfer = BankTransfer::find($id);
        if (!$bankTransfer) {
            return response()->json(['message' => 'Bank not found'], 404);
        }

        $bankTransfer->delete();
        return response()->json(['message' => 'Bank removed'], 200);
    }

    /**
     * Returns the specified resource from storage.
     */
    public function restore(string $id)
    {
        $bankTransfer = BankTransfer::onlyTrashed()->find($id);
        if (!$bankTransfer) {
            return response()->json(['message' => 'Bank not found'], 404);
        }
    
        $bankTransfer->restore();
        return response()->json(['message' => 'Bank restored'], 200);
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete(string $id)
    {
        $bankTransfer = BankTransfer::onlyTrashed()->find($id);
        if (!$bankTransfer) {
            return response()->json(['message' => 'Bank not found'], 404);
        }
    
        $bankTransfer->forceDelete();
        return response()->json(['message' => 'Bank permanently deleted'], 200);
    }
}
