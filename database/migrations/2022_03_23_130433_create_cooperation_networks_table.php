<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCooperationNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperation_networks', function (Blueprint $table) {
            $table->id();
            $table->string('network_title')->comment('ชื่อ')->nullable();    
            $table->string('network_intro')->comment('รายละเอียดย่อ')->nullable();
            $table->text('network_file_text')->comment('รายละเอียดหลัก')->nullable();
            $table->date('network_date')->comment('วันที่ลง')->nullable();
            $table->string('network_slug')->comment('ชื่อลิงค์')->nullable();
            $table->string('network_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('network_image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->integer('network_status')->comment('0 = draft 1=public  2= no/off')->nullable();   
            $table->string('file_pdf')->nullable(); 
            
            $table->string('network_meta_title')->nullable();  
            $table->text('network_meta_description')->nullable();  
            $table->text('network_meta_keyword')->nullable();  

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
        Schema::dropIfExists('cooperation_networks');
    }
}
