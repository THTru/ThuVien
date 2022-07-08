<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImgController extends Controller
{
    public function getimg(){
        // $img_path = '..\..\..\storage\app\public\image.jpg';
        $img_path ='C:\xampp\htdocs\login-backend\storage\app\public\image.jpg';
        // return response($img_path)->header('Content-type','image/jpeg');
        return response()->file($img_path);
    }
}
