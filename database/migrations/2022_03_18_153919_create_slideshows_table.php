<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideshowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('หัวข้อ')->nullable();    
            $table->string('link')->comment('ลิงค์')->nullable();    
            $table->string('image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->char('slide_type', 1)->default(1)->comment('1=สไลด์หลัก / 2=สื่อวิดิทัศน์'); 
            $table->string('file_pdf')->nullable();
            
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
        Schema::dropIfExists('slideshows');
    }
}
