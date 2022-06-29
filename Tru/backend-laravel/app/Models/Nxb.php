<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nxb extends Model
{
    use HasFactory;

    protected $table='nxb';

    protected $guarded = [];

    public function sach(){
        return $this->hasMany(Sach::class, 'id_nxb', 'id');
    }
}
