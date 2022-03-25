<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_activity_conservation extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'acticonservation_title',
        'acticonservation_intro',
        'acticonservation_file_text',
        'acticonservation_date',
        'acticonservation_slug',
        'acticonservation_image_thumb_desktop',  
        'acticonservation_image_desktop',
        'acticonservation_status',   
        'file_pdf',

        'acticonservation_meta_title',
        'acticonservation_meta_description',
        'acticonservation_meta_keyword',

        'created_at',
        'deleted_at',
    ];
}
