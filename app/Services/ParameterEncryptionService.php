<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log; // ✅ TAMBAH IMPORT INI

class ParameterEncryptionService
{
    private const DELIMITER = '|';
    private const DEFAULT_EXPIRY = 30; // menit
    private const MAX_LENGTH = 512; // karakter maksimal untuk URL

    /**
     * Enkripsi ID dengan semua konteks keamanan
     */
    public static function encrypt(
        string $subjectId,
        string $purpose,
        string $audience = 'web',
        ?string $userId = null,
        ?int $expiryMinutes = null,
        bool $allowReuse = true
    ): string {
        $timestamp = Carbon::now()->timestamp;
        $expiry = Carbon::now()->addMinutes($expiryMinutes ?? self::DEFAULT_EXPIRY)->timestamp;
        $nonce = bin2hex(random_bytes(8));
        
        // Build payload dengan semua konteks
        $payloadData = [
            'sub' => $subjectId,                    // Subject (ID asli)
            'aud' => $audience,                     // Audience (tenant/app)
            'iss' => config('app.name'),           // Issuer
            'iat' => $timestamp,                   // Issued at
            'exp' => $expiry,                      // Expiry
            'pur' => $purpose,                     // Purpose
            'non' => $nonce,                       // Nonce untuk replay protection
            'uid' => $userId ?? '',                // User ID context
            'reu' => $allowReuse ? '1' : '0'       // Allow reuse flag
        ];

        $payload = implode(self::DELIMITER, array_values($payloadData));
        $encrypted = Crypt::encrypt($payload);
        $encoded = self::base64UrlEncode($encrypted);

        // Validasi panjang untuk kompatibilitas URL
        if (strlen($encoded) > self::MAX_LENGTH) {
            throw new \Exception('Encrypted parameter too long for URL');
        }

        // Replay protection untuk single-use tokens
        if (!$allowReuse) {
            self::storeNonce($nonce, $purpose, $expiryMinutes ?? self::DEFAULT_EXPIRY);
        }

        return $encoded;
    }

    /**
     * Dekripsi dan validasi dengan semua checks
     */
    public static function decrypt(
        string $encryptedParam,
        string $expectedPurpose,
        string $expectedAudience = 'web',
        ?string $expectedUserId = null,
        bool $validateUserContext = true
    ): array {
        try {
            // Decode dan decrypt
            $decoded = self::base64UrlDecode($encryptedParam);
            $payload = Crypt::decrypt($decoded);
            
            // Parse payload
            $parts = explode(self::DELIMITER, $payload);
            
            if (count($parts) < 9) {
                throw new \Exception('Invalid payload structure');
            }

            [
                $subjectId, 
                $audience, 
                $issuer, 
                $issuedAt, 
                $expiry, 
                $purpose, 
                $nonce, 
                $userId,
                $allowReuse
            ] = $parts;

            // Validasi expiry
            if (Carbon::now()->timestamp > $expiry) {
                throw new \Exception('Token expired');
            }

            // Validasi audience
            if ($audience !== $expectedAudience) {
                throw new \Exception('Invalid audience');
            }

            // Validasi purpose
            if ($purpose !== $expectedPurpose) {
                throw new \Exception('Invalid purpose');
            }

            // Validasi user context jika diperlukan
            if ($validateUserContext && $expectedUserId && $userId !== $expectedUserId) {
                throw new \Exception('User context mismatch');
            }

            // Replay protection untuk single-use tokens
            if ($allowReuse === '0') {
                self::validateNonce($nonce, $purpose);
            }

            return [
                'subject_id' => $subjectId,
                'audience' => $audience,
                'issuer' => $issuer,
                'issued_at' => $issuedAt,
                'expiry' => $expiry,
                'purpose' => $purpose,
                'nonce' => $nonce,
                'user_id' => $userId,
                'allow_reuse' => $allowReuse === '1'
            ];

        } catch (DecryptException $e) {
            throw new \Exception('Invalid token: decryption failed');
        } catch (\Exception $e) {
            throw new \Exception('Token validation failed: ' . $e->getMessage());
        }
    }

    /**
     * Validasi cepat untuk middleware
     */
    public static function validate(
        string $encryptedParam,
        string $expectedPurpose,
        string $expectedAudience = 'web',
        ?string $expectedUserId = null
    ): bool {
        try {
            self::decrypt($encryptedParam, $expectedPurpose, $expectedAudience, $expectedUserId);
            return true;
        } catch (\Exception $e) {
            Log::warning('Parameter validation failed', [ // ✅ PERBAIKI: Log bukan \Log
                'purpose' => $expectedPurpose,
                'audience' => $expectedAudience,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Dapatkan hanya subject ID (untuk penggunaan sederhana)
     */
    public static function getSubjectId(
        string $encryptedParam,
        string $expectedPurpose,
        string $expectedAudience = 'web',
        ?string $expectedUserId = null
    ): string {
        $data = self::decrypt($encryptedParam, $expectedPurpose, $expectedAudience, $expectedUserId);
        return $data['subject_id'];
    }

    /**
     * Store nonce untuk replay protection
     */
    private static function storeNonce(string $nonce, string $purpose, int $expiryMinutes): void
    {
        $key = "nonce:{$purpose}:{$nonce}";
        Cache::put($key, true, $expiryMinutes + 5); // Extra margin
    }

    /**
     * Validate nonce untuk replay protection
     */
    private static function validateNonce(string $nonce, string $purpose): void
    {
        $key = "nonce:{$purpose}:{$nonce}";
        
        if (Cache::has($key)) {
            throw new \Exception('Token already used (replay detected)');
        }
        
        // Mark as used untuk request ini
        Cache::put($key, true, 5); // 5 menit cukup untuk request
    }

    /**
     * URL-safe base64 encode
     */
    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * URL-safe base64 decode
     */
    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    /**
     * Generate encrypted URL parameter
     */
    public static function generateUrlParameter(
        string $paramName,
        string $subjectId,
        string $purpose,
        string $audience = 'web',
        ?string $userId = null,
        ?int $expiryMinutes = null,
        bool $allowReuse = true
    ): string {
        $encrypted = self::encrypt($subjectId, $purpose, $audience, $userId, $expiryMinutes, $allowReuse);
        return "{$paramName}=" . urlencode($encrypted);
    }
}