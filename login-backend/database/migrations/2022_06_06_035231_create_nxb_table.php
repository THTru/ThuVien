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
        Schema::create('nxb', function (Blueprint $table) {
            $table->id();
            $table->string('tennxb');
            $table->timestamps();
        });

        DB::table('nxb')->insert([
            ['tennxb' => 'Chưa xác định'],
            ['tennxb' => 'Nhà xuất bản Kim Đồng'],
            ['tennxb' => 'Nhà xuất bản Trẻ'],
            ['tennxb' => 'Nhà xuất bản Giáo dục và Đào tạo']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nxb');
    }
};
