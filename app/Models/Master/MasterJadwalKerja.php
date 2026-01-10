<?php

namespace App\Models\Master;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class MasterJadwalKerja extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $table = 'master_jadwal_kerja';

    protected $primaryKey = 'id_jadwal_kerja';

    protected $fillable = [
        'id_libur',
        'nama_jadwal',
        'jam_masuk',
        'jam_pulang',
        'istirahat_mulai',
        'istirahat_selesai',
        'toleransi_menit',
        'keterangan',
        'dibuat_oleh',
    ];

    protected $guarded = [
        'id_jadwal_kerja',
    ];

    protected $casts = [
        'id_jadwal_kerja' => 'integer',
        'id_libur' => 'integer',
        'dibuat_oleh' => 'integer',
        'toleransi_menit' => 'integer',
    ];

    public function libur()
    {
        return $this->belongsTo(MasterLibur::class, 'id_libur', 'id_libur');
    }

    public function setNamaJadwalAttribute($value): void
    {
        $this->attributes['nama_jadwal'] = trim(strip_tags($value));
    }

    public function setKeteranganAttribute($value): void
    {
        $this->attributes['keterangan'] = $value ? trim(strip_tags($value)) : null;
    }
}
