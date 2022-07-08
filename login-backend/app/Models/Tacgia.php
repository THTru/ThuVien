<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tacgia extends Model
{
    use HasFactory;

    protected $table='tacgia';

    protected $guarded = [];

    public function sach(){
        return $this->hasMany(Sach::class, 'id_tacgia', 'id');
    }
}
