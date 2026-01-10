<?php

namespace App\Models\Absensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Absensi extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'att';

    protected $table = 'absensi';

    protected $primaryKey = 'id_absensi';

    protected $fillable = [
        'tanggal',
        'id_jadwal_karyawan',
        'id_sdm',
        'total_jam_kerja',
        'total_terlambat',
        'total_pulang_awal',
    ];

    protected $guarded = [
        'id_absensi',
    ];

    protected $casts = [
        'id_absensi' => 'integer',
        'tanggal' => 'date',
        'id_jadwal_karyawan' => 'integer',
        'id_sdm' => 'integer',
        'total_jam_kerja' => 'decimal:2',
        'total_terlambat' => 'decimal:2',
        'total_pulang_awal' => 'decimal:2',
    ];
}
