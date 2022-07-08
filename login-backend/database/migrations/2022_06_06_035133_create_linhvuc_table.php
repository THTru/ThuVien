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
        Schema::create('linhvuc', function (Blueprint $table) {
            $table->id();
            $table->string('tenlinhvuc');
            $table->timestamps();
        });

        DB::table('linhvuc')->insert([
            ['tenlinhvuc' => 'Khác/Chưa xác định'],
            ['tenlinhvuc' => 'Khoa học'],
            ['tenlinhvuc' => 'Nghệ thuật'],
            ['tenlinhvuc' => 'Xã hội'],
            ['tenlinhvuc' => 'Giáo dục']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linhvuc');
    }
};
