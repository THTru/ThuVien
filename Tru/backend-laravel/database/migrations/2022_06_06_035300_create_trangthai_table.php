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
        Schema::create('trangthai', function (Blueprint $table) {
            $table->id();
            $table->string('tentrangthai');
            $table->timestamps();
        });

        DB::table('trangthai')->insert([
            ['tentrangthai' => 'Bình thường'],
            ['tentrangthai' => 'Mất sách'],
            ['tentrangthai' => 'Bỏ sách'],
            ['tentrangthai' => 'Đang cho mượn']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trangthai');
    }
};
