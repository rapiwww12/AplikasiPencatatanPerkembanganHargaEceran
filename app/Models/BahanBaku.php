<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $guarded = ['id'];

    public function hargaItems()
    {
        return $this->hasMany(Harga::class);
    }

    public function latestHarga()
    {
        return $this->hasOne(Harga::class)->latestOfMany('tanggal');
    }

}
