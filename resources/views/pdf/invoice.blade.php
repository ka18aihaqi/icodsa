<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { padding: 20px; }
        .signature { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Invoice</h2>
        <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Status:</strong> {{ $invoice->status }}</p>
        <p><strong>Created At:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
        
        <h3>Letter of Acceptance Details</h3>
        @if ($invoice->letterOfAcceptance)
            <p><strong>Author Name:</strong> {{ $invoice->letterOfAcceptance->author_name }}</p>
            <p><strong>Institution:</strong> {{ $invoice->letterOfAcceptance->institution }}</p>
            <p><strong>Email:</strong> {{ $invoice->letterOfAcceptance->email }}</p>
            <p><strong>Conference Title:</strong> {{ $invoice->letterOfAcceptance->conference_title }}</p>
            <p><strong>Paper ID:</strong> {{ $invoice->letterOfAcceptance->paper_id }}</p>
            <p><strong>Paper Title:</strong> {{ $invoice->letterOfAcceptance->paper_title }}</p>
            <p><strong>Issued At:</strong> {{ $invoice->letterOfAcceptance->issued_at }}</p>

            @if ($invoice->letterOfAcceptance->signature)
                <div class="signature">
                    <p><strong>Signature:</strong></p>
                    <img src="{{ public_path('storage/' . $invoice->letterOfAcceptance->signature) }}" alt="Signature" width="150">
                </div>
            @endif
        @else
            <p><strong>Letter of Acceptance not found.</strong></p>
        @endif


        <p><strong>Quantity:</strong> {{ $invoice->quantity }}</p>
        <p><strong>Currency:</strong> {{ $invoice->currency }}</p>

        <p><strong>Bank Transfer ID:</strong> {{ $invoice->bank_transfer_id ?? '-' }}</p>
        <p><strong>Virtual Account ID:</strong> {{ $invoice->virtual_account_id ?? '-' }}</p>

        <p><strong>Description:</strong> {{ $invoice->description ?? '-' }}</p>
        <p><strong>Price:</strong> {{ $invoice->price ?? '-' }}</p>
        <p><strong>Total:</strong> {{ $invoice->total ?? '-' }}</p>
        
        <p><strong>Status:</strong> {{ $invoice->status }}</p>
    </div>
</body>
</html>
