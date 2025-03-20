<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with([
            'letterofAcceptance:id,author_name,institution,email,conference_title,paper_id,paper_title,issued_at,signature'
        ])->get();
    
        return response()->json(['invoices' => $invoices], 200);
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
        $invoice = Invoice::with([
            'letterofAcceptance:id,author_name,institution,email,conference_title,paper_id,paper_title,issued_at,signature'
        ])->find($id);
    
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
    
        return response()->json($invoice, 200);
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
    
        $validatedData = $request->validate([
            'invoice_number' => [
                'required',
                'string',
                Rule::unique('invoices', 'invoice_number')->ignore($invoice->id),
            ],
            'loa_id' => 'required|exists:letter_of_acceptances,id',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'currency' => 'required|in:IDR,USD,EUR',
            'price' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'virtual_account_id' => 'nullable|exists:virtual_accounts,id',
            'bank_transfer_id' => 'nullable|exists:bank_transfers,id',
            'status' => 'required|in:Paid,Unpaid',
        ]);

        $invoice->update($validatedData);
    
        return response()->json($invoice, 200);
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
        $invoice = Invoice::with('letterofAcceptance')->where('id', $id)->first();
    
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
    
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
    
        return $pdf->download("Invoice_{$invoice->id}.pdf");
    }
}
