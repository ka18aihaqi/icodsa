<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = Receipt::with([
            'invoice:id,invoice_number,loa_id',
            'invoice.letterOfAcceptance:id,conference_title,paper_id,paper_title,issued_at,signature'
        ])->get();
    
        return response()->json(['Receipts' => $receipts], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receipt = Receipt::with([
            'invoice:id,invoice_number,loa_id',
            'invoice.letterOfAcceptance:id,conference_title,paper_id,paper_title,issued_at,signature'
        ])->find($id);
    
        if (!$receipt) {
            return response()->json(['message' => 'Receipt not found'], 404);
        }
    
        return response()->json($receipt, 200);
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $receipt = Receipt::find($id);
        if (!$receipt) {
            return response()->json(['message' => 'Receipt not found'], 404);
        }
    
        $validatedData = $request->validate([
            'invoice_id' => 'required|exists:invoices,id', // Foreign key ke invoices
            'received_from' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0', 
            'in_payment_of' => 'nullable|string',
            'payment_date' => 'nullable|date', 
        ]);
    
        $receipt->update($validatedData);
    
        return response()->json($receipt, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Download the specified resource from storage.
     */
    public function downloadPDF($id)
    {
        $receipt = Receipt::with('invoice.letterOfAcceptance')->where('id', $id)->first();
    
        if (!$receipt) {
            return response()->json(['message' => 'Receipt not found'], 404);
        }
    
        $pdf = Pdf::loadView('pdf.receipt', compact('receipt'));
    
        return $pdf->download("Receipt_{$receipt->id}.pdf");
    }
}
