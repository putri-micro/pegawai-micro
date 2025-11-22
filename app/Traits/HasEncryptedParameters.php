<?php

namespace App\Traits;

use App\Services\ParameterEncryptionService;
use Illuminate\Support\Facades\Auth; // Tambahkan import ini

trait HasEncryptedParameters
{
    /**
     * Generate encrypted parameter untuk model
     */
    public function getEncryptedParameter(
        string $purpose,
        string $audience = 'web',
        ?string $userId = null,
        ?int $expiryMinutes = null,
        bool $allowReuse = true
    ): string
    {
        $userId = $userId ?? (Auth::check() ? Auth::id() : null);
        
        return ParameterEncryptionService::encrypt(
            $this->getKey(),
            $purpose,
            $audience,
            $userId,
            $expiryMinutes,
            $allowReuse
        );
    }

    // Tambahkan method ini di trait HasEncryptedParameters
public function getEncryptedUrl(
    string $routeName,
    string $purpose,
    string $audience = 'web',
    ?int $expiryMinutes = null,
    bool $allowReuse = true
): string {
    $encryptedParam = $this->getEncryptedParameter(
        $purpose, 
        $audience, 
        Auth::id(), 
        $expiryMinutes, 
        $allowReuse
    );
    
    return route($routeName, ['encryptedId' => $encryptedParam]);
}
}