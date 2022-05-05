<?php

namespace App\Traits;

use App\Models\College;

trait BelongsToCollege
{
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }
}
