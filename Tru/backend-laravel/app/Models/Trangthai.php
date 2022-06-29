<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trangthai extends Model
{
    use HasFactory;

    protected $table='trangthai';

    protected $guarded = [];

    public function sach(){
        return $this->hasMany(Sach::class, 'id_trangthai', 'id');
    }
}
