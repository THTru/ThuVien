<?php

namespace App\Http\Controllers;
use App\Models\Sach;
use App\Models\Nxb;
use App\Models\Theloai;
use App\Models\Tacgia;
use App\Models\Linhvuc;
use App\Models\Nganh;
use App\Models\Trangthai;
use Illuminate\Http\Request;

class Bookcontroller extends Controller
{
    public function Showall()
    {
        // $book = Sach::join('trangthai', 'sach.id_trangthai', '=', 'trangthai.id')
        //                 ->select('sach.*', 'trangthai.tentrangthai')
        //                 ->get();
        $book = Sach::get();
        return $book;
    }
    
    public function AddBook(Request $request)
    {
        $fields = $request->validate([
            'tensach' => 'required|string',
            'id_theloai' => 'required|int',
            'id_tacgia' => 'required|int',
            'id_nxb' => 'required|int',
            'id_linhvuc' => 'required|int',
            'id_nganh' => 'required|int',
            'id_trangthai' => 'required|int',
            'gia' => 'required|int'
            
        ]);
        $book = Sach::create([
            'tensach' => $fields['tensach'],
            'id_theloai' => $fields['id_theloai'],
            'tensach' => $fields['tensach'],
            'id_tacgia' => $fields['id_tacgia'],
            'id_nxb' => $fields['id_nxb'],
            'id_linhvuc' => $fields['id_linhvuc'],
            'id_nganh' => $fields['id_nganh'],
            'id_trangthai' => $fields['id_trangthai'],
            'gia' => $fields['gia'],
        ]);

        $book = Sach::get();
        return $book;
    }

    public function UpdateBookbyID(Request $request, $id)
    {
        try{
            $book = Sach::find($id);
            $book->tensach = $request->input('tensach');
            $book->id_theloai = $request->input('id_theloai');
            $book->id_tacgia = $request->input('id_tacgia');
            $book->id_nxb = $request->input('id_nxb');
            $book->id_linhvuc = $request->input('id_linhvuc');
            $book->id_nganh = $request->input('id_nganh');
            $book->id_trangthai = $request->input('id_trangthai');
            $book->gia = $request->input('gia');

            $book->save();
            return response()->json($book);
        } catch(Exception $e){
            return response(['message' => 'khò khò', 'status' => 404]);
        }
    }

    public function SearchByName(Request $request)
    {
        
        // $fields = $request->get([
        //     'tensach' => 'string',
        // ]);
        $search = $request->get('q');
        // $book = Sach::where('tensach', 'like', "%".$param."%")->get();
        $book = Sach::join('trangthai', 'sach.id_trangthai', '=', 'trangthai.id')
                        ->join('linhvuc', 'sach.id_linhvuc', '=', 'linhvuc.id')
                        ->join('nganh', 'sach.id_nganh', '=', 'nganh.id')
                        ->join('nxb', 'sach.id_nxb', '=', 'nxb.id')
                        ->join('tacgia', 'sach.id_tacgia', '=', 'tacgia.id')
                        ->join('theloai', 'sach.id_theloai', '=', 'theloai.id')
                        ->where('sach.tensach', 'like', "%".$search."%")
                        ->select('sach.id', 'sach.tensach', 'trangthai.tentrangthai', 'linhvuc.tenlinhvuc', 'nganh.tennganh', 'nxb.tennxb', 'tacgia.tentacgia', 'theloai.tentheloai', 'sach.gia')
                        ->get();
        return $book;
        
    }

    public function SearchTrangthaiByName(Request $request)
    {
        // $book = Sach::where('tensach', 'like', "%".$param."%")->get();
        $search = $request->get('q');
        $book = Sach::join('trangthai', 'sach.id_trangthai', '=', 'trangthai.id')
                        ->where('trangthai.tentrangthai', 'like', "%".$search."%")
                        ->select('sach.tensach', 'trangthai.tentrangthai')
                        ->get();
        return $book;
        
    }

    public function SuaTrangthai(Request $request, $id)
    {
        $book = Sach::find($id);
        $book->tensach = $request->input('tensach');
        $book->id_trangthai = $request->input('id_trangthai');
        $book->gia = $request->input('gia');

        $book->save();
        return response()->json($book);
    }

    // public function test(Request $req)
    // {
    //     $fields = $req->validate([
    //         'test'=>'string'
    //     ]);
    //     // $param = ([
    //     //     'test' => $fields['test']
    //     // ]);
    //     return response($fields);
    // }

    // Mấy cái get get ==============================
    public function getTheLoai(Request $req)
    {
        return Theloai::orderBy('id')->get();
    }

    public function getTacGia(Request $req)
    {
        return Tacgia::orderBy('id')->get();
    }

    public function getNXB(Request $req)
    {
        return Nxb::orderBy('id')->get();
    }

    public function getLinhVuc(Request $req)
    {
        return Linhvuc::orderBy('id')->get();
    }

    public function getNganh(Request $req)
    {
        return Nganh::orderBy('id')->get();
    }
    
    public function getTrangThai(Request $req)
    {
        return Trangthai::orderBy('id')->get();
    }
}

