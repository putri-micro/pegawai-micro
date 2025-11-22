<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\ParameterEncryptionService; // IMPORT YANG BENAR

class ValidateEncryptedParameter
{
    public function handle(Request $request, Closure $next, string $purpose, string $audience = 'web')
    {
        // Cari parameter terenkripsi dari router, query, atau input
        $encryptedParam = $this->findEncryptedParameter($request);

        if (!$encryptedParam) {
            abort(400, 'Missing encrypted parameter'); // Perbaiki: 400 bukan #@@
        }

        try {
            $userId = Auth::check() ? Auth::id() : null;

            // Validasi parameter
            $valid = ParameterEncryptionService::validate(
                $encryptedParam,
                $purpose,
                $audience,
                $userId
            );

            if (!$valid) {
                Log::warning('Encrypted parameter validation failed', [
                    'purpose' => $purpose,
                    'audience' => $audience,
                    'user_id' => $userId
                ]);
                abort(400, 'Invalid encrypted parameter');
            }

            return $next($request);

        } catch (\Exception $e) {
            Log::error('Encrypted parameter validation error', [
                'error' => $e->getMessage(),
                'purpose' => $purpose
            ]);
            abort(400, 'Parameter validation error');
        }
    }

    private function findEncryptedParameter(Request $request)
    {
        // Implementasi pencarian parameter terenkripsi
        return $request->input('encrypted_param') 
            ?? $request->query('encrypted_param') 
            ?? null;
    }
}