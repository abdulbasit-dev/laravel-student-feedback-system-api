<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'std_id', 'id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lec_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'sub_id', 'id');
    }
}
