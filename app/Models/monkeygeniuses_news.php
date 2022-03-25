<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_news extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'news_title',
        'news_intro',
        'news_file_text',
        'news_date',
        'news_slug',
        'news_image_thumb_desktop',  
        'news_image_desktop',
        'news_status',   
        'file_pdf',

        'news_meta_title',
        'news_meta_description',
        'news_meta_keyword',
        
        'created_at',
        'deleted_at',
    ];
}
