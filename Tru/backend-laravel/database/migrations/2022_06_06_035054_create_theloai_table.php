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
        Schema::create('theloai', function (Blueprint $table) {
            $table->id();
            $table->string('tentheloai');
            $table->timestamps();
        });

        DB::table('theloai')->insert([
            ['tentheloai' => 'Khác/Chưa xác định'],
            ['tentheloai' => 'Truyện chữ'],
            ['tentheloai' => 'Truyện tranh'],
            ['tentheloai' => 'Sách giáo khoa']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theloai');
    }
};
