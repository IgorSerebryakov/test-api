<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class TaskStatus extends Model
{
    use AsSource, Filterable, Attachable, HasFactory;

    protected $fillable = ['name'];
    public function tasks(): hasMany
    {
        return $this->hasMany(Task::class);
    }
}
