<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class acticonservation_gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'acticonservation_id_id',    
        'image',    
        'deleted_at',
    ];
}
