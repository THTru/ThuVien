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
        Schema::create('nganh', function (Blueprint $table) {
            $table->id();
            $table->string('tennganh');
            $table->timestamps();
        });

        DB::table('nganh')->insert([
            ['tennganh' => 'Khác/Chưa xác định'],
            ['tennganh' => 'Văn học'],
            ['tennganh' => 'Tin học'],
            ['tennganh' => 'Kinh tế']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nganh');
    }
};
