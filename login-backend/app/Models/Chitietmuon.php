<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietmuon extends Model
{
    use HasFactory;

    protected $table='chitietmuon';

    protected $fillable=[];

    public function phieumuon(){
        return $this->belongsTo(Phieumuon::class, 'id_phieumuon');
    }

    public function sach(){
        return $this->belongsTo(Sach::class, 'id_sach');
    }
}
