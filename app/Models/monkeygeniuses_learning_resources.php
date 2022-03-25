<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_learning_resources extends Model
{
    use HasFactory;
    protected $fillable = [
        'learning_category',
        'learning_title',  
        'learning_location',
        'learning_year',
        'learning_publishing_agency',
        'learning_date',
        'learning_image_thumb_desktop',
        'learning_image_desktop',
        'learning_file_pdf',
        'file_text',
        'link_vdo',
        'learning_status', 

        'learning_meta_title',
        'learning_meta_description',
        'learning_meta_keyword',

        'created_at',
        'deleted_at',
    ];
}
