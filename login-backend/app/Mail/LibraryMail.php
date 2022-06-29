<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bandoc;
use App\Models\Phieumuon;
use App\Models\Chitietmuon;

class LibraryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $phieumuon;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Phieumuon $phieumuon)
    {
        $this->phieumuon = $phieumuon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this
            ->subject('Nhắc nhở trả sách')
            ->view('mail')
            ->with([
                'id_bandoc' => $this->phieumuon->bandoc->id,
                'tenbandoc' => $this->phieumuon->bandoc->tenbandoc,
                'ngaymuon' => $this->phieumuon->ngaymuon,
                'ngayhen' => $this->phieumuon->ngayhentra,
                'chitietmuon' => $this->phieumuon->chitietmuon
            ]);
    }
}
