<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sach;
use App\Models\Nganh;
use App\Models\Linhvuc;
use App\Models\Theloai;
use App\Models\Tacgia;
use App\Models\Nxb;
use App\Models\Trangthai;
use App\Models\Bandoc;
use App\Models\Chitietmuon;
use App\Models\Phieumuon;

class ThuvienController extends Controller
{
    //
    public function thuvienindex()
    {

        // $sachs = Sach::get();
        $sachs = DB::table('sach')
        ->leftjoin('nganh', 'sach.id_nganh', '=', 'nganh.id')
        ->leftjoin('linhvuc', 'sach.id_linhvuc', '=', 'linhvuc.id')
        ->leftJoin('theloai', 'sach.id_theloai', '=', 'theloai.id')
        ->leftJoin('tacgia', 'sach.id_tacgia', '=', 'tacgia.id')
        ->leftJoin('nxb', 'sach.id_nxb', '=', 'nxb.id')
        ->leftJoin('trangthai', 'sach.id_trangthai', '=', 'trangthai.id')
        ->select('sach.id', 'sach.tensach', 'nganh.tennganh', 'linhvuc.tenlinhvuc', 'theloai.tentheloai', 'tacgia.tentacgia', 'nxb.tennxb', 'trangthai.tentrangthai')
        ->get();

        return response()->json($sachs);
    }


    public function xoasach(Request $req)
    {
        $sach = Sach::find($req->id)->delete();
        // $sachs = Sach::get();
        // return response()->json($sachs);

    }

    public function chondata()
    {
        $nganhs = Nganh::all();
        $linhvucs = Linhvuc::all();
        $theloais = Theloai::all();
        $tacgias = Tacgia::all(); 
        $nxbs = Nxb::all();
        $trangthais = Trangthai::all();
        return [
            'nganh' => $nganhs,
            'linhvuc' => $linhvucs,
            'theloai' => $theloais,
            'tacgia' => $tacgias,
            'nxb' => $nxbs,
            'trangthai' => $trangthais
        ];
    }

    public function themsach(Request $req){
        $newsach = new Sach;
        $newsach->tensach = $req->tensach;
        $newsach->id_nganh = $req->id_nganh;
        $newsach->id_linhvuc = $req->id_linhvuc;
        $newsach->id_theloai = $req->id_theloai;
        $newsach->id_tacgia = $req->id_tacgia;
        $newsach->id_nxb = $req->id_nxb;
        $newsach->id_trangthai = $req->id_trangthai;
        $newsach->created_at = now();
        $newsach->updated_at = now();
        $newsach->save();
    }

    public function suasach(Request $req)
    {
        $sach = DB::table('sach')
        ->leftjoin('nganh', 'sach.id_nganh', '=', 'nganh.id')
        ->leftjoin('linhvuc', 'sach.id_linhvuc', '=', 'linhvuc.id')
        ->leftJoin('theloai', 'sach.id_theloai', '=', 'theloai.id')
        ->leftJoin('tacgia', 'sach.id_tacgia', '=', 'tacgia.id')
        ->leftJoin('nxb', 'sach.id_nxb', '=', 'nxb.id')
        ->leftJoin('trangthai', 'sach.id_trangthai', '=', 'trangthai.id')
        ->select('sach.id', 'sach.tensach', 
        'sach.id_nganh','nganh.tennganh', 
        'sach.id_linhvuc', 'linhvuc.tenlinhvuc', 
        'sach.id_theloai','theloai.tentheloai', 
        'sach.id_tacgia','tacgia.tentacgia', 
        'sach.id_nxb','nxb.tennxb',
        'sach.id_trangthai', 'trangthai.tentrangthai')
        ->where('sach.id', $req->id)->first();
        // ->find($req->id);

        return response()->json($sach);
    }

    public function capnhatsach(Request $req){
        $sach = Sach::find($req->id);
        $sach->tensach = $req->tensach;
        $sach->id_nganh = $req->id_nganh;
        $sach->id_linhvuc = $req->id_linhvuc;
        $sach->id_theloai = $req->id_theloai;
        $sach->id_tacgia = $req->id_tacgia;
        $sach->id_nxb = $req->id_nxb;
        $sach->id_trangthai = $req->id_trangthai;
        // $danhmuc->nsx = $req->nsx;
        // $danhmuc->created_at = now();
        // $danhmuc->updated_at = now();
        $sach->save();
        // return response()->json($danhmuc);
    }

    public function themmoinganh(Request $req){
        $nganh = Nganh::where('tennganh', $req->tennganh)->first();
        if($nganh === null){
            $newnganh = new Nganh;
            $newnganh->tennganh = $req->tennganh;
            $newnganh->created_at = now();
            $newnganh->updated_at = now();
            $newnganh->save();
            return 1;
        }
        else return 0;
    }

    public function themmoilinhvuc(Request $req){
        $linhvuc = Linhvuc::where('tenlinhvuc', $req->tenlinhvuc)->first();
        if($linhvuc === null){
            $newlinhvuc = new Linhvuc;
            $newlinhvuc->tenlinhvuc = $req->tenlinhvuc;
            $newlinhvuc->created_at = now();
            $newlinhvuc->updated_at = now();
            $newlinhvuc->save();
            return 1;
        }
        else return 0;   
    }

    public function themmoitheloai(Request $req){
        $theloai = Theloai::where('tentheloai', $req->tentheloai)->first();
        if($theloai === null){
            $newtheloai = new Theloai;
            $newtheloai->tentheloai = $req->tentheloai;
            $newtheloai->created_at = now();
            $newtheloai->updated_at = now();
            $newtheloai->save();
            return 1;
        }
        else return 0;    
    }

    public function themmoitacgia(Request $req){
        $tacgia = Tacgia::where('tentacgia', $req->tentacgia)->first();
        if($tacgia === null){
            $newtacgia = new Tacgia;
            $newtacgia->tentacgia = $req->tentacgia;
            $newtacgia->created_at = now();
            $newtacgia->updated_at = now();
            $newtacgia->save();
            return 1;
        }
        else return 0;    
    }

    public function themmoinxb(Request $req){
        $nxb = Nxb::where('tennxb', $req->tennxb)->first();
        if($nxb === null){
            $newnxb = new Nxb;
            $newnxb->tennxb = $req->tennxb;
            $newnxb->created_at = now();
            $newnxb->updated_at = now();
            $newnxb->save();
            return 1;
        }
        else return 0;    
    }

    public function xoanganh(Request $req)
    {
        $sach = Sach::where('id_nganh', $req->id)->first();
        if($sach === null){
            $nganh = Nganh::find($req->id)->delete();
            return 1;
        }
        else{
            return 0;
        }
    }

    public function xoalinhvuc(Request $req)
    {
        $sach = Sach::where('id_linhvuc', $req->id)->first();
        if($sach === null){
            $linhvuc = Linhvuc::find($req->id)->delete();
            return 1;
        }
        else{
            return 0;
        }
    }

    public function xoatheloai(Request $req)
    {
        $sach = Sach::where('id_theloai', $req->id)->first();
        if($sach === null){
            $theloai = Theloai::find($req->id)->delete();
            return 1;
        }
        else{
            return 0;
        }
    }

    public function xoatacgia(Request $req)
    {
        $sach = Sach::where('id_tacgia', $req->id)->first();
        if($sach === null){
            $tacgia = Tacgia::find($req->id)->delete();
            return 1;
        }
        else{
            return 0;
        }
    }

    public function xoanxb(Request $req)
    {
        $sach = Sach::where('id_nxb', $req->id)->first();
        if($sach === null){
            $nxb = Nxb::find($req->id)->delete();
            return 1;
        }
        else{
            return 0;
        }
    }
    
    public function indexbandoc()
    {
        $bandocs = Bandoc::get();
        return response()->json($bandocs);
    }

    public function guiphieu()
    {
        $solanmuon = Phieumuon::get();
        return $solanmuon;
    }

    public function topmuon()
    {
        $list = [];
        $sach= Sach::with('tacgia','nxb')->get();
        foreach($sach as $item){
            $n = 0;
            $chitiet = Chitietmuon::get();
            foreach($chitiet as $item2){
                if($item2->id_sach == $item->id) $n++;
            }
            $object =[ 'sach' => $item, 'n' => $n ];
            array_push($list, $object);
        }

        return $list;
    }

    public function chitietbandoc(Request $req)
    {
        $chitiet = Chitietmuon::whereHas('phieumuon', function($query) use($req) {
            $query->where('id_bandoc', $req->id);
        })->with('phieumuon', 'sach')->get();
        return $chitiet;
    }

    public function suanganh(Request $req)
    {
        $nganh = Nganh::find($req->id);
        $nganh->tennganh = $req->tennganh;
        $nganh->save();
        return Nganh::all();
    }

    public function sualinhvuc(Request $req)
    {
        $linhvuc = Linhvuc::find($req->id);
        $linhvuc->tenlinhvuc = $req->tenlinhvuc;
        $linhvuc->save();
    }

    public function suatheloai(Request $req)
    {
        $theloai = Theloai::find($req->id);
        $theloai->tentheloai = $req->tentheloai;
        $theloai->save();
    }

    public function suatacgia(Request $req)
    {
        $tacgia = Tacgia::find($req->id);
        $tacgia->tentacgia = $req->tentacgia;
        $tacgia->save();
    }

    public function suanxb(Request $req)
    {
        $nxb = Nxb::find($req->id);
        $nxb->tennxb = $req->tennxb;
        $nxb->save();
    }

}
