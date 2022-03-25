<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learning_category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'detail',   
        'deleted_at',
    ];
}
