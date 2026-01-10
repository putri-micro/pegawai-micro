<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefBank extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_bank';

    protected $primaryKey = 'id_bank';

    protected $fillable = [
        'nama_bank',
        'kode_swift',
        'customer_service',
    ];

    protected $guarded = [
        'id_bank',
    ];

    protected $casts = [
        'id_bank' => 'integer',
    ];

    public function setNamaBankAttribute($value): void
    {
        $this->attributes['nama_bank'] = trim(strip_tags($value));
    }

    public function setKodeSwiftAttribute($value): void
    {
        $this->attributes['kode_swift'] = trim(strip_tags($value));
    }

    public function setCustomerServiceAttribute($value): void
    {
        $this->attributes['customer_service'] = trim(strip_tags($value));
    }
}
