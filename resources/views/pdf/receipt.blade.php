<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { padding: 20px; }
        .signature { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Receipt</h2>
        <p><strong>Receipt ID:</strong> {{ $receipt->id }}</p>
        <p><strong>Invoice Number:</strong> {{ $receipt->invoice->invoice_number }}</p>
        <p><strong>Received From:</strong> {{ $receipt->received_from ?? '-' }}</p>
        <p><strong>Amount:</strong> {{ number_format($receipt->amount, 2) }}</p>
        <p><strong>Payment Date:</strong> {{ $receipt->payment_date ? date('d M Y', strtotime($receipt->payment_date)) : '-' }}</p>
        <p><strong>Description:</strong> {{ $receipt->in_payment_of ?? '-' }}</p>

        <h3>Letter of Acceptance</h3>
        <p><strong>Conference Title:</strong> {{ $receipt->invoice->letterOfAcceptance->conference_title }}</p>
        <p><strong>Paper ID:</strong> {{ $receipt->invoice->letterOfAcceptance->paper_id }}</p>
        <p><strong>Paper Title:</strong> {{ $receipt->invoice->letterOfAcceptance->paper_title }}</p>
        <p><strong>Issued At:</strong> {{ $receipt->invoice->letterOfAcceptance->issued_at }}</p>

        @if ($receipt->invoice->letterOfAcceptance->signature)
            <div class="signature">
                <p><strong>Signature:</strong></p>
                <img src="{{ public_path('storage/' . $receipt->invoice->letterOfAcceptance->signature) }}" alt="Signature" width="150">
            </div>
        @endif
    </div>
</body>
</html>
