<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monkeygeniuses_book extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_type',
        'book_title', 
        'book_author',
        'book_keyword',
        'book_year',
        'book_publishing_agency',
        'book_date',
        'book_image_thumb_desktop',
        'book_image_desktop',
        'book_file_pdf',
        'book_status', 

        'book_meta_title',
        'book_meta_description',
        'book_meta_keyword',

        'created_at',
        'deleted_at',
    ];
}
