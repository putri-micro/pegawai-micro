@php
    // Generate secure links untuk tombol di UI
    $secureUrl = $invoice->getEncryptedUrl(
        'invoices.secure.download',
        'secure_download', 
        'web',
        15,
        false
    );
    
    $viewUrl = route('invoices.view', [
        'encryptedId' => $invoice->getEncryptedParameter('view_invoice')
    ]);
@endphp

<a href="{{ $secureUrl }}" class="btn btn-danger">Secure Download</a>
<a href="{{ $viewUrl }}" class="btn btn-primary">View Invoice</a>