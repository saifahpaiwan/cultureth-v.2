<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonkeygeniusesActivityConservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monkeygeniuses_activity_conservations', function (Blueprint $table) {
            $table->id();
            $table->string('acticonservation_title')->comment('ชื่อกิจกรรมอนุรักษ์')->nullable();    
            $table->string('acticonservation_intro')->comment('รายละเอียดย่อ')->nullable();
            $table->text('acticonservation_file_text')->comment('รายละเอียดหลัก')->nullable();
            $table->date('acticonservation_date')->comment('วันที่ลง')->nullable();
            $table->string('acticonservation_slug')->comment('ชื่อลิงค์')->nullable();
            $table->string('acticonservation_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('acticonservation_image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->integer('acticonservation_status')->comment('0 = draft 1=public  2= no/off')->nullable(); 
            $table->string('file_pdf')->nullable();   
            
            $table->string('acticonservation_meta_title')->nullable();  
            $table->text('acticonservation_meta_description')->nullable();  
            $table->text('acticonservation_meta_keyword')->nullable();  
            
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
        Schema::dropIfExists('monkeygeniuses_activity_conservations');
    }
}
