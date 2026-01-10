<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class TarifPotongan extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'tarif_potongan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'potongan_id',
        'nama_potongan',
        'tarif_per_kejadian',
        'deskripsi',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'tarif_per_kejadian' => 'decimal:2',
    ];
}
