<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_task');
    }

    public function syncTags(array $tagIds)
    {
        $this->tags()->sync($tagIds);
    }
}
