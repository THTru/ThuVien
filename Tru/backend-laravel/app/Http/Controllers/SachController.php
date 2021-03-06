<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Sach;
use App\Models\Nxb;
use App\Models\Theloai;
use App\Models\Tacgia;
use App\Models\Linhvuc;
use App\Models\Nganh;
use App\Models\Trangthai;
use App\Models\Bandoc;
use App\Models\Phieumuon;
use App\Models\Chitietmuon;
use App\Mail\LibraryMail;
use PhpOffice\PhpWord\TemplateProcessor;

class SachController extends Controller
{
    public function test(Request $req){
        $list = [];
        $bandoc = Bandoc::all();
        foreach($bandoc as $nguoimuon){
            $res = Chitietmuon::whereHas('phieumuon', function($query) use($nguoimuon) {
                $query -> where('id_bandoc', $nguoimuon->id);
            })->get(['id_sach']);
            $array = [];
            foreach($res as $item) array_push($array, $item->id_sach);
            $counter = array_count_values($array);
            arsort($counter);

            $temp = [];
            foreach($counter as $counterx => $value){
                $book = Sach::find($counterx);
                $bookdetail = $book->id.' - '.$book->tensach;
                $t = [ 'sach' => $bookdetail, 'n' => $value ];
                array_push($temp, $t);
            }
            array_push($list, $temp);
        }
        return $list;
    }

    public function getbook(Request $req){
        return Sach::orderBy('tensach')->with('trangthai')->get();
    }

    public function getbookid(Request $req){
        return Sach::with('trangthai')->get();
    }

    public function getreader(Request $req){
        return Bandoc::orderBy('tenbandoc')->get();
    }

    public function getreaderid(Request $req){
        return Bandoc::all();
    }

    public function getdetail(Request $req){
        if ($req->id_form==0) return Chitietmuon::with('sach', 'phieumuon.bandoc')->get();
        else return Chitietmuon::where('id_phieumuon', $req->id_form)->with('sach', 'phieumuon.bandoc')->get();
    }

    public function borrowform(Request $req){
        return Phieumuon::with('bandoc', 'chitietmuon')->get();
    }

    public function bookhistory(Request $req){
        $res = Sach::where('id', $req->id)->with('chitietmuon.phieumuon.bandoc')->get();
        // $res = Chitietmuon::where('id_sach', $req->id)->with('phieumuon.bandoc')->get();
        return $res;
    }

    public function readerhistory(Request $req){
        // $res = Bandoc::find($req->id)->with('phieumuon.chitietmuon.sach')->get();
        $res = Chitietmuon::whereHas('phieumuon', function($query) use($req) {$query->where('id_bandoc', $req->id);})
            ->with('sach', 'phieumuon.bandoc',)->get();
        return $res;
    }

    public function borrow(Request $req){
        $listbook = []; $countbook = 0; $available = 1;
        foreach($req->id_sach as $book){
            if($book != 0) {
                array_push($listbook, $book);
                $countbook++;
                $status=Sach::where('id', $book)->first(['id_trangthai'])->id_trangthai;
                if ($status != 1) $available = 0;
            }
        }
        $unique = array_unique($listbook);
        $date1 = date($req->y1.'-'.$req->m1.'-'.$req->d1);
        $date2 = date($req->y2.'-'.$req->m2.'-'.$req->d2);

        if($req->id_bandoc == 0) return "Ch??a ch???n ng?????i m?????n";
        else if($countbook == 0) return "Ch??a ch???n s??ch";
        else if($available == 0) return "C?? s??ch ch???n kh??ng th??? m?????n";
        else if(count($unique) != count($listbook)) return "S??ch ch???n b??? tr??ng";
        else if($date1 >= $date2) return "Ng??y h???n tr??? ph???i sau ng??y m?????n";
        else{
            $phieumuon = new Phieumuon;
            $phieumuon->id_bandoc = $req->id_bandoc;
            $phieumuon->ngaymuon = $date1;
            $phieumuon->ngayhentra = $date2;
            $phieumuon->save();

            foreach($listbook as $n){
                $chitietmuon = new Chitietmuon;
                $chitietmuon->id_sach = $n;
                $chitietmuon->id_phieumuon = $phieumuon->id;
                $chitietmuon->save();

                $sach = Sach::find($n);
                $sach->id_trangthai = 4;
                $sach->save();
            }

            return "M?????n th??nh c??ng";
        }
    }

    public function returnbook(Request $req){
        $chitietmuon = Chitietmuon::find($req->id);
        $ngaytra = $req->y.'/'.$req->m.'/'.$req->d;

        $date1 = strtotime($chitietmuon->phieumuon->ngaymuon);
        $date2 = strtotime($ngaytra);
        if($date1 >= $date2) return "Ng??y tr??? ph???i sau ng??y m?????n";
        else {
            $chitietmuon->ngaytra=$ngaytra;
            $chitietmuon->trangthaitra=$req->status;
            $chitietmuon->save();

            $sach = Sach::find($chitietmuon->id_sach);
            $sach->id_trangthai = 1;
            $sach->save();

            return "Tr??? s??ch th??nh c??ng";
        }
    }

    public function detailbyid(Request $req){
        $res = Chitietmuon::where('id', $req->id)->with('sach.trangthai', 'phieumuon.bandoc')->get();
        return $res;
    }

    public function editdetail(Request $req){
        $chitietmuon = Chitietmuon::find($req->id);
        $date = date($req->y.'-'.$req->m.'-'.$req->d);

        $dif = 0;
        if($chitietmuon->trangthaitra != $req->trangthaitra) $dif++;
        if(strtotime($chitietmuon->ngaytra) != strtotime($date)) $dif++;
        if($dif==0) return "N???i dung kh??ng thay ?????i";

        if(strtotime($chitietmuon->phieumuon->ngaymuon) >= strtotime($date))
            return "Ng??y tr??? ph???i sau ng??y m?????n";

        $chitietmuon->ngaytra = $date;
        $chitietmuon->trangthaitra = $req->trangthaitra;
        $chitietmuon->save();
        return 1;
    }

    public function deletedetail(Request $req){
        $chitietmuon = Chitietmuon::find($req->id);
        $sach = Sach::find($chitietmuon->id_sach);
        if($sach->id_trangthai == 4){
            $sach->id_trangthai = 1;
            $sach->save();
        }
        return $chitietmuon->delete();
    }

    public function confirmlost(Request $req){
        $chitietmuon = Chitietmuon::find($req->id);
        $chitietmuon->trangthaitra = 'M???t s??ch';
        $chitietmuon->save();

        $sach = Sach::find($chitietmuon->id_sach);
        $sach->id_trangthai=2;
        $sach->save();
        return true;
    }

    public function formbyid(Request $req){
        $phieumuon = Phieumuon::where('id', $req->id)->with('bandoc')->get();
        return $phieumuon;
    }

    public function editform(Request $req){
        $phieumuon = Phieumuon::find($req->id_phieumuon);
        $date1 = date($req->y1.'-'.$req->m1.'-'.$req->d1);
        $date2 = date($req->y2.'-'.$req->m2.'-'.$req->d2);
        $dif=0;
        if($phieumuon->id_bandoc != $req->id_bandoc) $dif++;
        if(strtotime($date1) != strtotime($phieumuon->ngaymuon)) $dif++;
        if(strtotime($date2) != strtotime($phieumuon->ngayhentra)) $dif++;
        if($dif===0)
            return "N???i dung kh??ng c?? thay ?????i";
        else{
            $phieumuon->id_bandoc = $req->id_bandoc;
            $phieumuon->ngaymuon = $date1;
            $phieumuon->ngayhentra = $date2;
            $phieumuon->save();
            return 1;
        }
    }

    public function deleteform(Request $req){
        $phieumuon = Phieumuon::find($req->id);
        $count=0;
        foreach($phieumuon->chitietmuon as $chitiet){
            $sach=Sach::find($chitiet->id_sach);
            if($sach->id_trangthai==4){
                $sach->id_trangthai=1;
                $sach->save();
            }
            $chitiet->delete();
        }
        return $phieumuon->delete();
    }

    public function sendmail(Request $req){
        $sendto='50zygarde50@gmail.com';
        $id_phieumuon= $req->id;
        $phieumuon = Phieumuon::find($id_phieumuon);
        $mailable = new LibraryMail($phieumuon);
        Mail::to($sendto)->queue($mailable);
        return true;
    }

    public function detailbydate(Request $req){
        $date1 = date($req->y1.'-'.$req->m1.'-'.$req->d1);
        $date2 = date($req->y2.'-'.$req->m2.'-'.$req->d2);

        $chitietmuon = Chitietmuon::whereDate('ngaytra', '>=', $date1)
                    ->whereDate('ngaytra', '<=', $date2)
                    ->orWhereHas('phieumuon', function($query) use($date1, $date2)
                    {$query->whereDate('ngaymuon', '>=', $date1)
                        ->whereDate('ngaymuon', '<=', $date2);})
                    ->with('phieumuon.bandoc', 'sach')->get();
        // $chitietmuon = Chitietmuon::with('phieumuon.bandoc', 'sach')->get();
        return $chitietmuon;
    }

    public function exportreport(Request $req){
        $date1 = date($req->y1.'-'.$req->m1.'-'.$req->d1);
        $date2 = date($req->y2.'-'.$req->m2.'-'.$req->d2);
        $nborrow = 0; $nreturn = 0; $nlost = 0; $nnormal = 0;

        $chitietmuon = Chitietmuon::whereDate('ngaytra', '>=', $date1)
                    ->whereDate('ngaytra', '<=', $date2)
                    ->orWhereHas('phieumuon', function($query) use($date1, $date2)
                    {$query->whereDate('ngaymuon', '>=', $date1)
                        ->whereDate('ngaymuon', '<=', $date2);})
                    ->with('phieumuon.bandoc', 'sach')->get();
        
        $templateProcessor = new TemplateProcessor('word-template/BorrowReportTemplate.docx');
        $templateProcessor->setValue('ngay1', $date1);
        $templateProcessor->setValue('ngay2', $date2);

        $values = [];
        foreach($chitietmuon as $chitiet){
            if(strtotime($chitiet->phieumuon->ngaymuon)>=strtotime($date1)) $nborrow++;
            if($chitiet->trangthaitra=='M???t s??ch') $nlost++;
            if($chitiet->trangthaitra=='B??nh th?????ng') $nnormal++;
            $tmp_ngaytra = '';
            if($chitiet->ngaytra != '1900-01-01') {$tmp_ngaytra = $chitiet->ngaytra; $nreturn++;}
            $tmp = [ 'id_phieumuon' => $chitiet->phieumuon->id,
                    'id_bandoc' => $chitiet->phieumuon->bandoc->id,
                    'tenbandoc' => $chitiet->phieumuon->bandoc->tenbandoc,
                    'id_sach' => $chitiet->sach->id,
                    'tensach' => $chitiet->sach->tensach,
                    'ngaymuon' => $chitiet->phieumuon->ngaymuon,
                    'ngayhen' => $chitiet->phieumuon->ngayhentra,
                    'ngaytra' => $tmp_ngaytra,
                    'trangthaitra' => $chitiet->trangthaitra];
            array_push($values, $tmp);
        }
        $templateProcessor->setValue('nborrow', $nborrow);
        $templateProcessor->setValue('nreturn', $nreturn);
        $templateProcessor->setValue('nlost', $nlost);
        $templateProcessor->setValue('nnormal', $nnormal);

        $templateProcessor->cloneRowAndSetValues('id_phieumuon', $values);
        $templateProcessor->saveAs(storage_path('test.docx'));
        return response()->download(storage_path('test.docx'))->deleteFileAfterSend(true);
    }
}
