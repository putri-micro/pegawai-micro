<?php

namespace App\Services;

class ValidationService
{
    private const WEAK_PASSWORDS = [
        'Password123!', 'Qwerty2024!', 'Welcome1!', 'Admin123!',
        'Password1!', 'Qwerty123!', 'Welcome123!', 'Admin2024!',
        'Simpeg2024!', 'Unuja2024!', 'Test1234!', 'Abcdefg1!'
    ];

    public static function validateUsername($username)
    {
        if (strlen($username) < 4 || strlen($username) > 20) {
            return 'Username harus 4-20 karakter';
        }

        if (!preg_match('/^[a-zA-Z]/', $username)) {
            return 'Username harus diawali dengan huruf';
        }

        if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
            return 'Username hanya boleh mengandung huruf, angka, dan underscore';
        }

        if (strpos($username, '__') !== false) {
            return 'Username tidak boleh mengandung dua underscore berurutan';
        }

        return null;
    }

    public static function validatePassword($password)
    {
        if (strlen($password) < 10 || strlen($password) > 64) {
            return 'Password harus 10-64 karakter';
        }

        if (preg_match('/\s/', $password)) {
            return 'Password tidak boleh mengandung spasi';
        }

        $hasLower = preg_match('/[a-z]/', $password);
        $hasUpper = preg_match('/[A-Z]/', $password);
        $hasDigit = preg_match('/[0-9]/', $password);
        $hasSpecial = preg_match('/[@$!%*#?&_\-+=.,;:]/', $password);

        if (!$hasLower) {
            return 'Password harus mengandung minimal 1 huruf kecil';
        }

        if (!$hasUpper) {
            return 'Password harus mengandung minimal 1 huruf besar';
        }

        if (!$hasDigit) {
            return 'Password harus mengandung minimal 1 angka';
        }

        if (!$hasSpecial) {
            return 'Password harus mengandung minimal 1 simbol (@$!%*#?&_-+=.,;:)';
        }

        if (in_array($password, self::WEAK_PASSWORDS)) {
            return 'Password terlalu umum, gunakan kombinasi yang lebih unik';
        }

        return null;
    }

    public static function validateEmail($email)
    {
        if (strlen($email) > 254) {
            return 'Email terlalu panjang (maksimal 254 karakter)';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Format email tidak valid';
        }

        list($localPart, $domain) = explode('@', $email);

        if (preg_match('/\.\./', $localPart)) {
            return 'Email tidak boleh mengandung dua titik berurutan';
        }

        if (preg_match('/\s/', $localPart)) {
            return 'Email tidak boleh mengandung spasi';
        }

        $domainParts = explode('.', $domain);
        if (count($domainParts) < 2) {
            return 'Domain email tidak valid';
        }

        $tld = end($domainParts);
        if (strlen($tld) < 2) {
            return 'TLD domain harus minimal 2 karakter';
        }

        return null;
    }

    public static function validatePhone($phone)
    {
        if (!preg_match('/^\d+$/', $phone)) {
            return 'Nomor telepon hanya boleh mengandung angka';
        }

        if (strlen($phone) < 8 || strlen($phone) > 15) {
            return 'Nomor telepon harus 8-15 digit';
        }

        if (preg_match('/^(08|62)/', $phone)) {
            if (preg_match('/^08/', $phone)) {
                if (strlen($phone) < 10 || strlen($phone) > 13) {
                    return 'Nomor telepon Indonesia harus 10-13 digit untuk format 08';
                }
            } else if (preg_match('/^62/', $phone)) {
                if (strlen($phone) < 11 || strlen($phone) > 15) {
                    return 'Nomor telepon Indonesia harus 11-15 digit untuk format 62';
                }
            }
        } else {
            return 'Nomor telepon Indonesia harus dimulai dengan 08 atau 62';
        }

        return null;
    }

    public static function maskEmail($email)
    {
        if (!str_contains($email, '@')) {
            return $email;
        }

        list($localPart, $domain) = explode('@', $email);
        
        $localLength = strlen($localPart);
        if ($localLength <= 4) {
            $maskedLocal = substr($localPart, 0, 1) . '***';
        } else {
            $maskedLocal = substr($localPart, 0, 2) . '***' . substr($localPart, -2);
        }

        $domainParts = explode('.', $domain);
        $maskedDomain = '';
        
        foreach ($domainParts as $index => $part) {
            if ($index === 0) {
                $maskedDomain .= substr($part, 0, 2) . '**';
            } elseif ($index === count($domainParts) - 1) {
                $maskedDomain .= '.' . substr($part, 0, 1);
            } else {
                $maskedDomain .= '.' . substr($part, 0, 1) . '*';
            }
        }

        return $maskedLocal . '@' . ltrim($maskedDomain, '.');
    }
}