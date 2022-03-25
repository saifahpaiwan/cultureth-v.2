<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_activity extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'activity_title',
        'activity_intro',
        'activity_file_text',
        'activity_date',
        'activity_slug',
        'activity_image_thumb_desktop',  
        'activity_image_desktop',
        'activity_status',   
        'file_pdf',

        'activity_meta_title',
        'activity_meta_description',
        'activity_meta_keyword',

        'created_at',
        'deleted_at',
    ];
}
