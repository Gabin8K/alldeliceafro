<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Article $article) {
            $article->slug = Str::slug($article->name_en);
            $article->name_fr = $article->name_fr ?? $article->name_en;
            $article->name_de = $article->name_de ?? $article->name_en;
        });

        static::updating(function (Article $article) {
            $article->slug = Str::slug($article->name_en);
            $article->name_fr = $article->name_fr ?? $article->name_en;
            $article->name_de = $article->name_de ?? $article->name_en;
        });
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class)
            ->withPivot([
                'price'
            ])
            ->withTimestamps();
    }
}
