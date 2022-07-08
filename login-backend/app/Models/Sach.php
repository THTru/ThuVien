<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    use HasFactory;

    protected $table='sach';

    protected $guarded = [];

    public function nxb(){
        return $this->belongsTo(Nxb::class, 'id_nxb');
    }

    public function theloai(){
        return $this->belongsTo(Theloai::class, 'id_theloai');
    }

    public function tacgia(){
        return $this->belongsTo(Tacgia::class, 'id_tacgia');
    }

    public function linhvuc(){
        return $this->belongsTo(Linhvuc::class, 'id_linhvuc');
    }

    public function nganh(){
        return $this->belongsTo(Nganh::class, 'id_nganh');
    }

    public function trangthai(){
        return $this->belongsTo(Trangthai::class, 'id_trangthai');
    }

    public function chitietmuon(){
        return $this->hasMany(Chitietmuon::class, 'id_sach', 'id');
    }
}
