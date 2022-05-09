<?php

namespace App\Models;

use App\Traits\BelongsToCollege;
use App\Traits\BelongsToDept;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory, BelongsToDept, BelongsToCollege;

    protected $guarded = [];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

}
