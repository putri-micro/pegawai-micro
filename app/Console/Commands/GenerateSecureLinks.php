<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class GenerateSecureLinks extends Command
{
    protected $signature = 'links:generate {invoice_id}';
    protected $description = 'Generate secure links for invoice';

    public function handle()
    {
        $invoice = Invoice::find($this->argument('invoice_id'));
        
        if (!$invoice) {
            $this->error('Invoice not found');
            return;
        }

        // High security - single use
        $secureToken = $invoice->getEncryptedParameter(
            'secure_download', 
            'web', 
            null, // No user context for command
            15, 
            false
        );

        $this->info("Secure Token: " . $secureToken);
        $this->info("Secure URL: " . route('invoices.secure.download', ['encryptedId' => $secureToken]));
    }
}