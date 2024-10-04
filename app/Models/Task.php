<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Task extends Model
{
    use Chartable, AsSource, HasFactory;

    protected $fillable = [
        'name',
        'status_id',
        'user_id'
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
