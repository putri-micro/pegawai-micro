<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;

class EncryptionService
{
    private const DELIMITER = '|';
    private const EXPIRY_MINUTES = 30; // 30 menit expiry

    /**
     * Enkripsi ID dengan konteks
     */
    public static function encryptId(
        string $id, 
        string $purpose, 
        string $audience = 'web', 
        ?string $userId = null
    ): string {
        $timestamp = Carbon::now()->timestamp;
        $expiry = Carbon::now()->addMinutes(self::EXPIRY_MINUTES)->timestamp;
        $nonce = bin2hex(random_bytes(8)); // Replay protection
        
        $data = [
            'sub' => $id,        // Subject (ID asli)
            'aud' => $audience,  // Audience (tenant/app)
            'iss' => config('app.name'), // Issuer
            'iat' => $timestamp, // Issued at
            'exp' => $expiry,    // Expiry
            'pur' => $purpose,   // Purpose
            'non' => $nonce,     // Nonce untuk replay protection
        ];

        // Tambahkan user ID jika tersedia (opsional)
        if ($userId) {
            $data['uid'] = $userId;
        }

        $payload = implode(self::DELIMITER, [
            $data['sub'],
            $data['aud'],
            $data['iss'],
            $data['iat'],
            $data['exp'],
            $data['pur'],
            $data['non'],
            $userId ?? ''
        ]);

        return self::base64UrlEncode(Crypt::encrypt($payload));
    }

    /**
     * Dekripsi dan validasi ID
     */
    public static function decryptId(
        string $encryptedId, 
        string $expectedPurpose, 
        string $expectedAudience = 'web',
        ?string $expectedUserId = null
    ): string {
        try {
            $payload = Crypt::decrypt(self::base64UrlDecode($encryptedId));
            
            $parts = explode(self::DELIMITER, $payload);
            
            if (count($parts) < 7) {
                throw new \Exception('Invalid payload structure');
            }

            [
                $id, 
                $audience, 
                $issuer, 
                $issuedAt, 
                $expiry, 
                $purpose, 
                $nonce, 
                $userId
            ] = array_pad($parts, 8, null);

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

            // Validasi user ID jika diperlukan
            if ($expectedUserId && $userId !== $expectedUserId) {
                throw new \Exception('User mismatch');
            }

            // TODO: Implement replay protection dengan menyimpan nonce yang digunakan
            // self::checkNonce($nonce, $purpose);

            return $id;

        } catch (DecryptException $e) {
            throw new \Exception('Invalid token');
        } catch (\Exception $e) {
            throw new \Exception('Token validation failed: ' . $e->getMessage());
        }
    }

    /**
     * Validasi cepat tanpa throw exception (untuk middleware)
     */
    public static function validateId(
        string $encryptedId, 
        string $expectedPurpose, 
        string $expectedAudience = 'web',
        ?string $expectedUserId = null
    ): bool {
        try {
            self::decryptId($encryptedId, $expectedPurpose, $expectedAudience, $expectedUserId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
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
     * Replay protection - simpan nonce yang sudah digunakan
     */
    private static function checkNonce(string $nonce, string $purpose): void
    {
        $key = "nonce:{$purpose}:{$nonce}";
        
        // Gunakan cache untuk menyimpan nonce yang sudah digunakan
        if (cache()->has($key)) {
            throw new \Exception('Token already used');
        }
        
        // Simpan nonce hingga expiry (plus margin)
        cache()->put($key, true, self::EXPIRY_MINUTES + 5);
    }
}