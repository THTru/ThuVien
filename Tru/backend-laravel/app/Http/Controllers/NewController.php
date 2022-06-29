<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tacgia;

class NewController extends Controller
{
    public function tacgia(){
        return Tacgia::all();
    }
}
