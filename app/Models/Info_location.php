<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info_location extends Model
{
    use HasFactory;
    protected $table = 'info_locations';
    protected $fillable = ['title', 'address', 'coordinate', 'rating', 'description' ];
}
