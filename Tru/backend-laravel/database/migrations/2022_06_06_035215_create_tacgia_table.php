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
        Schema::create('tacgia', function (Blueprint $table) {
            $table->id();
            $table->string('tentacgia');
            $table->timestamps();
        });

        DB::table('tacgia')->insert([
            ['tentacgia' => 'Chưa xác định'],
            ['tentacgia' => 'Nhiều tác giả'],
            ['tentacgia' => 'Nam Cao'],
            ['tentacgia' => 'Fujiko F. Fujio'],
            ['tentacgia' => 'Toriyama Akira']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tacgia');
    }
};
