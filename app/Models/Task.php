<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function created_by()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assigned_to()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\taskStatus');
    }
}
