<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theloai extends Model
{
    use HasFactory;

    protected $table='theloai';

    protected $guarded = [];

    public function sach(){
        return $this->hasMany(Sach::class, 'id_theloai', 'id');
    }
}
