<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phieumuon extends Model
{
    use HasFactory;

    protected $table ='phieumuon';

    protected $guarded = [];

    public function bandoc(){
        return $this->belongsTo(Bandoc::class, 'id_bandoc');
    }

    public function chitietmuon(){
        return $this->hasMany(Chitietmuon::class, 'id_phieumuon', 'id');
    }
}
