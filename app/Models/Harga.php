<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    protected $fillable = [
        'bahan_baku_id',
        'harga',
        'pasar',
        'tanggal',
        'created_by',
    ];

    public function BahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
