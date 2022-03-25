<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report_annual extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'annual_title',
        'annual_intro',
        'annual_file_text',
        'annual_date',
        'annual_slug',
        'annual_image_thumb_desktop',  
        'annual_image_desktop',
        'annual_status',   
        'file_pdf',

        'annual_meta_title',
        'annual_meta_description',
        'annual_meta_keyword',
        
        'created_at',
        'deleted_at',
    ];
}
