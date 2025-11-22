<?php

namespace App\Http\Controllers;

use App\Models\Invoice; // Fixed import
use Illuminate\Support\Facades\Auth;
use App\Services\ParameterEncryptionService;
use App\Traits\HasEncryptedParameters; // Fixed trait name

class SecureInvoiceController extends Controller
{
    use HasEncryptedParameters; // Fixed syntax

    /*
     * Generate secure invoice download link
     */
    public function generateSecureLink(Invoice $invoice)
    {
        // Single-use token untuk download yang sangat sensitif
        $encryptedId = $invoice->getEncryptedParameter(
            'secure_download',
            'web',
            Auth::id(),
            15, // expiry time dalam menit
            false // Single-use - tidak bisa di-reuse
        ); // Fixed: ) bukan }
        
        return response()->json([
            'secure_url' => route('invoices.secure.download', ['encryptedId' => $encryptedId]),
        ]);
    }

    // Tambahkan di SecureInvoiceController
public function secureDownload($encryptedId)
{
    try {
        $data = ParameterEncryptionService::decrypt(
            $encryptedId, 
            'secure_download', 
            'web', 
            Auth::id()
        );
        
        $invoice = Invoice::findOrFail($data['subject_id']);
        
        // Logic download file
        return response()->download($invoice->file_path);
        
    } catch (\Exception $e) {
        abort(403, 'Invalid or expired download link');
    }
}
}