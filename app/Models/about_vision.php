<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class about_vision extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',    
        'sub_title',
        'file_text', 
        'file_pdf',
        'image_thumb_desktop',
        'meta_title',  
        'meta_description',  
        'meta_keyword',    
        'deleted_at',
    ];
}
