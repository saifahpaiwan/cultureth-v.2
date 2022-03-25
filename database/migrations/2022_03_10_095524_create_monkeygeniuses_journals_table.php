<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonkeygeniusesJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monkeygeniuses_journals', function (Blueprint $table) {
            $table->id(); 
            $table->string('journal_title')->comment('ชื่อวารสาร ')->nullable();    
            $table->string('journal_year')->comment(' ปี วารสาร ')->nullable();  
            $table->string('journal_month')->comment(' เดือนวารสาร ')->nullable();  
            $table->text('journal_file_text')->nullable();    
            $table->string('journal_image_thumb_desktop')->comment('รูป thumb ใช้ในการแสดง โชว์ในระบบ และ แชร์​')->nullable();  
            $table->string('journal_image_desktop')->comment('รูปแสดงผล web')->nullable();   
            $table->integer('journal_status')->comment('0 = draft 1=public  2= no/off')->nullable();  
            $table->string('file_pdf')->nullable();  

            $table->string('journal_meta_title')->nullable();  
            $table->text('journal_meta_description')->nullable();  
            $table->text('journal_meta_keyword')->nullable();  

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
        Schema::dropIfExists('monkeygeniuses_journals');
    }
}
