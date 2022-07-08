<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linhvuc extends Model
{
    use HasFactory;

    protected $table='linhvuc';

    protected $guarded = [];

    public function sach(){
        return $this->hasMany(Sach::class, 'id_linhvuc', 'id');
    }
}
