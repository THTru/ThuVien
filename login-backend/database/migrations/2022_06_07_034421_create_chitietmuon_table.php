<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietmuon', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_phieumuon');
            $table->unsignedInteger('id_sach');
            $table->date('ngaytra')->default('1900-1-1');
            $table->string('trangthaitra')->default('Chưa trả');
            $table->timestamps();
        });

        DB::table('chitietmuon')->insert(
            [
                ['id_phieumuon' => 1, 'id_sach' => 1, 'ngaytra' => '2021-6-10', 'trangthaitra' => 'Bình thường'],
                ['id_phieumuon' => 1, 'id_sach' => 2, 'ngaytra' => '2021-6-10', 'trangthaitra' => 'Bình thường'],
                ['id_phieumuon' => 1, 'id_sach' => 3, 'ngaytra' => '2021-7-1', 'trangthaitra' => 'Bình thường'],
                ['id_phieumuon' => 1, 'id_sach' => 4, 'ngaytra' => '2021-7-1', 'trangthaitra' => 'Bị quăng góc'],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chitietmuon');
    }
};
