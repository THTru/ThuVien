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
        Schema::create('phieumuon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bandoc');
            $table->date('ngaymuon');
            $table->date('ngayhentra');
            $table->timestamps();

            $table->foreign('id_bandoc')->references('id')->on('bandoc')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });

        DB::table('phieumuon')->insert(
            [
                ['id_bandoc' => 2, 'ngaymuon' => '2021-06-07', 'ngayhentra' => '2021-07-07'],
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
        Schema::dropIfExists('phieumuon');
    }
};
