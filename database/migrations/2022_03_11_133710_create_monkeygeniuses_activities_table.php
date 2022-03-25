<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonkeygeniusesActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monkeygeniuses_activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_title')->comment('ชื่อกิจกรรม')->nullable();    
            $table->string('activity_intro')->comment('รายละเอียดย่อ')->nullable();
            $table->text('activity_file_text')->comment('รายละเอียดหลัก')->nullable();
            $table->date('activity_date')->comment('วันที่ลง')->nullable();
            $table->string('activity_slug')->comment('ชื่อลิงค์')->nullable();
            $table->string('activity_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('activity_image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->integer('activity_status')->comment('0 = draft 1=public  2= no/off')->nullable();   
            $table->string('file_pdf')->nullable(); 
            
            $table->string('activity_meta_title')->nullable();  
            $table->text('activity_meta_description')->nullable();  
            $table->text('activity_meta_keyword')->nullable();  

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
        Schema::dropIfExists('monkeygeniuses_activities');
    }
}
