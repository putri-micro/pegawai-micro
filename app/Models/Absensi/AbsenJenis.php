<?php

namespace App\Models\Absensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class AbsenJenis extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'att';

    protected $table = 'absen_jenis';

    protected $primaryKey = 'id_jenis_absen';

    protected $fillable = [
        'nama_absen',
        'kategori',
        'potong_gaji',
    ];

    protected $guarded = [
        'id_jenis_absen',
    ];

    protected $casts = [
        'id_jenis_absen' => 'integer',
        'potong_gaji' => 'integer', // User DB shows tinyint(1) which usually casts to boolean or integer. Explicitly integer for safety or boolean if standard. User asked for "potong_gaji" columns. Let's stick to simple integer or boolean. DB screenshot shows tinyint(1).
    ];

    public function setNamaAbsenAttribute($value): void
    {
        $this->attributes['nama_absen'] = trim(strip_tags($value));
    }
}
