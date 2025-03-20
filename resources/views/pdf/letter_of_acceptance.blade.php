<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Letter of Acceptance</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { padding: 20px; }
        .signature { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Letter of Acceptance</h2>
        <p><strong>Author Name:</strong> {{ $loa->author_name }}</p>
        <p><strong>Institution:</strong> {{ $loa->institution }}</p>
        <p><strong>Email:</strong> {{ $loa->email }}</p>
        <p><strong>Conference Title:</strong> {{ $loa->conference_title }}</p>
        <p><strong>Paper ID:</strong> {{ $loa->paper_id }}</p>
        <p><strong>Paper Title:</strong> {{ $loa->paper_title }}</p>
        <p><strong>Issued At:</strong> {{ $loa->issued_at }}</p>
        <p><strong>Status:</strong> {{ $loa->status }}</p>

        @if ($loa->signature)
            <div class="signature">
                <p><strong>Signature:</strong></p>
                <img src="{{ public_path('storage/' . $loa->signature) }}" alt="Signature" width="150">
            </div>
        @endif
    </div>
</body>
</html>
