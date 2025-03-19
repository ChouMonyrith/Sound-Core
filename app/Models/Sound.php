<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Sound extends Model
{
    protected $fillable = ['title','artist','genre','duration','description','file_path','image_path','category_id','user_id','status'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeTitle(Builder $query,string $title):Builder|QueryBuilder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeFilterByCategory(Builder $query, ?string $category): Builder|QueryBuilder
    {
        if ($category && $category !== 'all') {
            return $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        return $query;
    }
}
