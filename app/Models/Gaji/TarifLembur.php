<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class TarifLembur extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'tarif_lembur';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tarif_id',
        'jenis_lembur',
        'tarif_per_jam',
        'berlaku_mulai',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'tarif_per_jam' => 'decimal:2',
        'berlaku_mulai' => 'date',
    ];
}
