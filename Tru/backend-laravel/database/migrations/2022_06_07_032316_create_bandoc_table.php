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
        Schema::create('bandoc', function (Blueprint $table) {
            $table->id();
            $table->string('tenbandoc');
            $table->string('email')->unique();
            $table->string('sdt');
            $table->timestamps();
        });

        DB::table('bandoc')->insert(
            [
                ['tenbandoc' => 'Pikachu', 'email' => 'pikachu@gmail.com', 'sdt' => '123456789'],
                ['tenbandoc' => 'Doraemon', 'email' => 'doraemon@gmail.com', 'sdt' => '987654321'],
                ['tenbandoc' => 'Son Goku', 'email' => 'goku@gmail.com', 'sdt' => '010101010'],
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
        Schema::dropIfExists('bandoc');
    }
};
