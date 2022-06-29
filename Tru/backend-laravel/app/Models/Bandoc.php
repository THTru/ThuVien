<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandoc extends Model
{
    use HasFactory;

    protected $table='bandoc';

    protected $guarded=[];

    public function phieumuon(){
        return $this->hasMany(Phieumuon::class, 'id_bandoc', 'id');
    }
}
