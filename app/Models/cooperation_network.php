<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cooperation_network extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'network_title',
        'network_intro',
        'network_file_text',
        'network_date',
        'network_slug',
        'network_image_thumb_desktop',  
        'network_image_desktop',
        'network_status',   
        'file_pdf',

        'network_meta_title',
        'network_meta_description',
        'network_meta_keyword',
        
        'created_at',
        'deleted_at',
    ];
}
