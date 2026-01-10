<?php

namespace App\Models\Absensi;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class AbsensiDetail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'att';

    protected $table = 'absensi_detail';

    protected $primaryKey = 'id_detail';

    public $incrementing = true;

    protected $fillable = [
        'id_absensi',
        'id_jenis_absen',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_jam',
        'lokasi_pulang',
    ];

    protected $casts = [
        'id_detail' => 'integer',
        'id_absensi' => 'integer',
        'id_jenis_absen' => 'integer',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'durasi_jam' => 'decimal:2',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi', 'id_absensi');
    }

    public function jenisAbsen()
    {
        return $this->belongsTo(AbsenJenis::class, 'id_jenis_absen', 'id_jenis_absen');
    }
}
