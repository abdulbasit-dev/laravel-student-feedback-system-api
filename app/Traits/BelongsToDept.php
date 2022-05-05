<?php

namespace App\Traits;

use App\Models\Department;

trait BelongsToDept
{
    public function dept()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }
}
