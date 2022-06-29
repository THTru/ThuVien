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
        Schema::create('sach', function (Blueprint $table) {
            $table->id();
            $table->string('tensach');
            $table->unsignedInteger('id_theloai')->default(1);
            $table->unsignedInteger('id_tacgia')->default(1);
            $table->unsignedInteger('id_nxb')->default(1);
            $table->unsignedInteger('id_linhvuc')->default(1);
            $table->unsignedInteger('id_nganh')->default(1);
            $table->unsignedInteger('id_trangthai')->default(1);
            $table->unsignedBigInteger('gia')->default(0);
            $table->timestamps();
        });

        DB::table('sach')->insert([
            ['tensach' => 'Lão Hạc', 'id_theloai' => 2, 'id_tacgia' => 3, 'id_nxb' => 3, 'id_nganh' => 2, 'id_linhvuc' => 3, 'id_trangthai' => 1, 'gia' => 20000],
            ['tensach' => 'Doraemon truyện ngắn tập 1', 'id_theloai' => 3, 'id_tacgia' => 4, 'id_nxb' => 2, 'id_nganh' => 1, 'id_linhvuc' => 1, 'id_trangthai' => 1, 'gia' => 20000],
            ['tensach' => 'Dragonball tập 1', 'id_theloai' => 3, 'id_tacgia' => 5, 'id_nxb' => 2, 'id_nganh' => 1, 'id_linhvuc' => 1, 'id_trangthai' => 1, 'gia' => 20000],
            ['tensach' => 'Tiếng Việt 1 tập 1', 'id_theloai' => 4, 'id_tacgia' => 2, 'id_nxb' => 4, 'id_nganh' => 1, 'id_linhvuc' => 5, 'id_trangthai' => 1, 'gia' => 5000],
            ['tensach' => 'Tiếng Việt 1 tập 2', 'id_theloai' => 4, 'id_tacgia' => 2, 'id_nxb' => 4, 'id_nganh' => 1, 'id_linhvuc' => 5, 'id_trangthai' => 1, 'gia' => 5000],
            ['tensach' => 'Toán 1 tập 1', 'id_theloai' => 4, 'id_tacgia' => 2, 'id_nxb' => 4, 'id_nganh' => 1, 'id_linhvuc' => 5, 'id_trangthai' => 2, 'gia' => 5000],
            ['tensach' => 'Chí Phèo', 'id_theloai' => 2, 'id_tacgia' => 3, 'id_nxb' => 3, 'id_nganh' => 2, 'id_linhvuc' => 3, 'id_trangthai' => 1, 'gia' => 20000],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sach');
    }
};
