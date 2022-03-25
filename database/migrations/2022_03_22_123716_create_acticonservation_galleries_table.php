<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiconservationGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acticonservation_galleries', function (Blueprint $table) {
            $table->id();
            $table->integer('acticonservation_id')->comment('acticonservation id')->nullable(); 
            $table->string('image')->comment('รูปใช้ในการแสดง​')->nullable();    
            $table->ipAddress('ip_address');
            $table->timestamps();
            $table->char('deleted_at', 1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acticonservation_galleries');
    }
}
