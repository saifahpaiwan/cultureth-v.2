<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCommiteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_commitees', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('หัวข้อ')->nullable();    
            $table->string('sub_title')->comment('หัวข้อย่อย')->nullable();
            $table->text('file_text')->comment('ไฟล์ .text')->nullable();
            $table->text('image_thumb_desktop')->comment('ไฟล์ .img thumb')->nullable();
            $table->string('file_pdf')->nullable();
            
            $table->string('meta_title')->nullable();  
            $table->text('meta_description')->nullable();  
            $table->text('meta_keyword')->nullable();  
            
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
        Schema::dropIfExists('admin_commitees');
    }
}
