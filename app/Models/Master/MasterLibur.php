<?php

namespace App\Models\Master;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class MasterLibur extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $table = 'master_libur';

    protected $primaryKey = 'id_libur';

    protected $fillable = [
        'tanggal',
        'jenis_libur',
        'nama_libur',
        'keterangan',
    ];

    protected $guarded = [
        'id_libur',
    ];

    protected $casts = [
        'id_libur' => 'integer',
        'tanggal' => 'date',
    ];

    public function setNamaLiburAttribute($value): void
    {
        $this->attributes['nama_libur'] = trim(strip_tags($value));
    }

    public function setKeteranganAttribute($value): void
    {
        $this->attributes['keterangan'] = $value ? trim(strip_tags($value)) : null;
    }
}
