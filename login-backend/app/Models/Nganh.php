<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nganh extends Model
{
    use HasFactory;

    protected $table='nganh';

    protected $guarded = [];

    public function sach(){
        return $this->hasMany(Sach::class, 'id_nganh', 'id');
    }
}
