<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'status_id');
    }

    public function getFormattedUpdateTime()
    {
        return $this->updated_at?->format('d.m.Y');
    }
}
