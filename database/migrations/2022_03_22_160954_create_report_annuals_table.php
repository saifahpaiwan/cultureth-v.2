<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportAnnualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_annuals', function (Blueprint $table) {
            $table->id();
            $table->string('annual_title')->comment('ชื่อ')->nullable();    
            $table->string('annual_intro')->comment('รายละเอียดย่อ')->nullable();
            $table->text('annual_file_text')->comment('รายละเอียดหลัก')->nullable();
            $table->date('annual_date')->comment('วันที่ลง')->nullable();
            $table->string('annual_slug')->comment('ชื่อลิงค์')->nullable();
            $table->string('annual_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('annual_image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->integer('annual_status')->comment('0 = draft 1=public  2= no/off')->nullable();   
            $table->string('file_pdf')->nullable(); 
            
            $table->string('annual_meta_title')->nullable();  
            $table->text('annual_meta_description')->nullable();  
            $table->text('annual_meta_keyword')->nullable();  

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
        Schema::dropIfExists('report_annuals');
    }
}
