<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonkeygeniusesResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monkeygeniuses_researches', function (Blueprint $table) {
            $table->id();
            $table->integer('research_type')->comment('เป็น วิจัย หรือ บทความ')->nullable(); 
            $table->string('research_title')->comment('ชื่อเรียง')->nullable();  
            $table->string('research_name')->comment('ชื่อผู้แต่ง')->nullable();  
            $table->text('research_keyword')->comment('คำสำคัญ')->nullable();  
            $table->string('research_year')->comment('ปีที่วิจัย')->nullable();  
            $table->string('research_publishing_agency')->comment('หน่วยงานที่จัดพิมพ์')->nullable();  
            $table->text('research_detial')->comment('บทคัดย่อ')->nullable();  
            $table->date('research_date')->comment('วันที่ลง')->nullable();  
            $table->string('research_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('research_image_desktop')->comment('รูปแสดงผล web')->nullable();  
            $table->string('research_file_pdf')->nullable();  
            $table->integer('research_status')->comment('0 = draft 1=public  2= no/off')->nullable();   

            $table->string('research_meta_title')->nullable();  
            $table->text('research_meta_description')->nullable();  
            $table->text('research_meta_keyword')->nullable();  

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
        Schema::dropIfExists('monkeygeniuses_researches');
    }
}
