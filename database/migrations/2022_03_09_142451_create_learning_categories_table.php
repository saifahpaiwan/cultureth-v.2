<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อประเภทแหล่งเรียนรู้ ')->nullable();   
            $table->string('detail')->comment('รายละเอียดประเภทแหล่งเรียนรู้ ')->nullable();   

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
        Schema::dropIfExists('learning_categories');
    }
}
