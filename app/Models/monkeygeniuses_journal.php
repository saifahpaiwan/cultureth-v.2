<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_journal extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'journal_title',   
        'journal_year',
        'journal_month', 
        'journal_file_text',
        'journal_image_thumb_desktop',
        'journal_image_desktop', 
        'journal_status', 
        'file_pdf',

        'journal_meta_title',
        'journal_meta_description',
        'journal_meta_keyword',

        'created_at',
        'deleted_at',
    ];
}
