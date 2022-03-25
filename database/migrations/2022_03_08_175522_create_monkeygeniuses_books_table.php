<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonkeygeniusesBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monkeygeniuses_books', function (Blueprint $table) {
            $table->id();
            $table->integer('book_type')->comment('เป็น หนังสือ หรือ วารสารสำนักงาน ')->nullable(); 
            $table->string('book_title')->comment('ชื่อหนังสือ')->nullable();  
            $table->string('book_author')->comment('ชื่อผู้แต่ง')->nullable();  
            $table->text('book_keyword')->comment('คำสำคัญ')->nullable();    
            $table->string('book_year')->comment('ปีที่')->nullable();    
            $table->string('book_publishing_agency')->comment('หน่วยงานที่จัดพิมพ์')->nullable();    
            $table->date('book_date')->comment('วันที่ลง')->nullable();    
            $table->string('book_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable(); 
            $table->string('book_image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->string('book_file_pdf')->nullable(); 
            $table->integer('book_status')->comment('0 = draft 1=public  2= no/off')->nullable();   

            $table->string('book_meta_title')->nullable();  
            $table->text('book_meta_description')->nullable();  
            $table->text('book_meta_keyword')->nullable();  

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
        Schema::dropIfExists('monkeygeniuses_books');
    }
}
