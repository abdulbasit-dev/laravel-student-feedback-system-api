<?php

namespace App\Models;

use App\Traits\BelongsToCollege;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, BelongsToCollege;

    protected $fillable = ['college_id', 'name'];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'dept_id','id');
    }

    protected static function booted()
    {
        static::addGlobalScope('orderById', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }
}
