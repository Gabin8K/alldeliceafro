<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            $category->slug = Str::slug($category->name_en);
            $category->name_fr = $category->name_fr ?? $category->name_en;
            $category->name_de = $category->name_de ?? $category->name_en;
        });

        static::updating(function (Category $category) {
            $category->slug = Str::slug($category->name_en);
            $category->name_fr = $category->name_fr ?? $category->name_en;
            $category->name_de = $category->name_de ?? $category->name_en;
        });
    }

    public function image(): hasOne
    {
        return $this->hasOne(Image::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
