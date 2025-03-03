<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Label;

class Task extends Model
{

    protected $fillable = ['status_id', 'name', 'description', 'created_by_id', 'assigned_to_id'];

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
        return $this->belongsTo('App\Models\TaskStatus');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
