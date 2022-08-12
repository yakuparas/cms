<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;



class Category extends Model
{
    use HasFactory,Sluggable;
    public function sluggable(): array
    {
        return [
            'seo_url' => [
                'source' => 'title'
            ]
        ];
    }

    protected $appends=[
        'parent'
    ];



    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
}
