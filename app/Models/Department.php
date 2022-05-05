<?php

namespace App\Models;

use App\Traits\BelongsToCollege;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, BelongsToCollege;

    protected $fillable = ['college_id', 'name'];
}
