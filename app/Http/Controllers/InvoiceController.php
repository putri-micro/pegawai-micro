<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Generate secure links for invoice
     * URL: GET /invoices/{invoice}/links
     */
    public function generateInvoiceLinks(Invoice $invoice)
    {
        $userId = Auth::id();
        
        // Pastikan method ini ada di model Invoice
        $links = [
            'secure_download' => [
                'token' => $invoice->getEncryptedParameter('secure_download', 'web', $userId, 15, false),
                'url' => $invoice->getEncryptedUrl('invoices.secure.download', 'secure_download', 'web', 15, false),
            ]
        ];

        return response()->json($links);
    }
}