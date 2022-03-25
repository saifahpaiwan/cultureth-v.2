<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_research extends Model
{
    use HasFactory;
    protected $fillable = [
        'research_type',
        'research_title', 
        'research_author',
        'research_keyword',
        'research_year',
        'research_publishing_agency',
        'research_date',
        'research_image_thumb_desktop',
        'research_image_desktop',
        'research_file_pdf',
        'research_status', 

        'research_meta_title',
        'research_meta_description',
        'research_meta_keyword',

        'created_at',
        'deleted_at',
    ];
}
