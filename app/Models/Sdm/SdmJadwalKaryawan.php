<?php

namespace App\Models\Sdm;

use App\Models\Master\MasterJadwalKerja;
use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Sdm\PersonSdm;

final class SdmJadwalKaryawan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $table = 'sdm_jadwal_karyawan';

    protected $primaryKey = 'id_karyawan';

    public $incrementing = true;

    protected $fillable = [
        'id_sdm',
        'id_jadwal_kerja',
        'tanggal_mulai',
        'tanggal_selesai',
        'dibuat_oleh',
    ];

    protected $casts = [
        'id_karyawan' => 'integer',
        'id_sdm' => 'integer',
        'id_jadwal_kerja' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function jadwalKerja()
    {
        return $this->belongsTo(MasterJadwalKerja::class, 'id_jadwal_kerja', 'id_jadwal_kerja');
    }

    public function personSdm()
    {
        return $this->belongsTo(PersonSdm::class, 'id_sdm', 'id_sdm');
    }

    public function getTanggalMulaiAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }

    public function getTanggalSelesaiAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }
}
