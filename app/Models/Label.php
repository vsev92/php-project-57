<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Task;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public $tasks;

    public function getTasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function getFormattedUpdateTime()
    {
        return $this->updated_at?->format('d.m.Y');
    }
}
