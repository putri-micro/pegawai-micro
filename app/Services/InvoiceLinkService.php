<?php

namespace App\Services;

use App\Models\Invoice;


class InvoiceLinkService
{
    public function generateAllLinks(Invoice $invoice, $userId)
    {
        return [
            'secure_download' => $invoice->getEncryptedParameter(
                'secure_download', 
                'web', 
                $userId, 
                15, 
                false
            ),
            'view' => $invoice->getEncryptedParameter('view_invoice'),
            'preview' => $invoice->getEncryptedUrl(
                'invoices.preview',
                'preview_invoice',
                'web',
                60, // 1 hour
                true
            )
        ];
    }

    public function validateAccess($token, $purpose, $userId)
    {
        return ParameterEncryptionService::validate($token, $purpose, 'web', $userId);
    }
}