<?php

namespace App\Http\Controllers;

use App\Models\VirtualAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VirtualAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['VirtualAccount' => VirtualAccount::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'virtual_account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'bank_name' => 'required|string',
            'bank_branch' => 'required|string',
        ]);
    
        $VA = VirtualAccount::create($validatedData);
    
        return response()->json($VA, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $VA = VirtualAccount::where('id', $id)->first();
        if (!$VA) {
            return response()->json(['message' => 'VA not found'], 404);
        }
        return response()->json($VA, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $VA = VirtualAccount::find($id);
        if (!$VA) {
            return response()->json(['message' => 'VA not found'], 404);
        }
    
        $validatedData = $request->validate([
            'virtual_account_number' => [
                'required',
                'string',
                Rule::unique('virtual_accounts', 'virtual_account_number')->ignore($VA->id),
            ],
            'account_holder_name' => 'required|string',
            'bank_name' => 'required|string',
            'bank_branch' => 'required|string',
        ]);
    
        $VA->update($validatedData);
    
        return response()->json($VA, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $VA = VirtualAccount::find($id);
        if (!$VA) {
            return response()->json(['message' => 'VA not found'], 404);
        }

        $VA->delete();
        return response()->json(['message' => 'VA deleted'], 200);
    }

    /**
     * Returns the specified resource from storage.
     */
    public function restore(string $id)
    {
        $VA = VirtualAccount::onlyTrashed()->find($id);
        if (!$VA) {
            return response()->json(['message' => 'VA not found'], 404);
        }
    
        $VA->restore();
        return response()->json(['message' => 'VA restored'], 200);
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete(string $id)
    {
        $VA = VirtualAccount::onlyTrashed()->find($id);
        if (!$VA) {
            return response()->json(['message' => 'VA not found'], 404);
        }
    
        $VA->forceDelete();
        return response()->json(['message' => 'VA permanently deleted'], 200);
    }
}
