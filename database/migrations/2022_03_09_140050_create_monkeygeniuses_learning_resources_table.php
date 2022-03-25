<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonkeygeniusesLearningResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monkeygeniuses_learning_resources', function (Blueprint $table) {
            $table->id();
            $table->integer('learning_category')->comment('fix ประเภทแหล่งเรียนรู้ ')->nullable(); 
            $table->string('learning_title')->comment('ชื่อแหล่งเรียนรู้ ')->nullable();   
            $table->string('learning_location')->comment('สถานที่ตั้ง')->nullable();  
            $table->string('learning_year')->comment('ปีที่')->nullable();  
            $table->string('learning_publishing_agency')->comment('หน่วยงานจัดทำ')->nullable();   
            $table->date('learning_date')->comment('วันที่ลง')->nullable();  
            $table->string('learning_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('learning_image_desktop')->comment('รูปแสดงผล web')->nullable();  
            $table->string('learning_file_pdf')->nullable();
            $table->string('file_text')->nullable();   
            $table->text('link_vdo')->comment('link vdo')->nullable();   
            $table->integer('learning_status')->comment('0 = draft 1=public  2= no/off')->nullable();   

            $table->string('learning_meta_title')->nullable();  
            $table->text('learning_meta_description')->nullable();  
            $table->text('learning_meta_keyword')->nullable();  

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
        Schema::dropIfExists('monkeygeniuses_learning_resources');
    }
}
