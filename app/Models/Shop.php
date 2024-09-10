<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Shop $shop) {
            $shop->slug = Str::slug($shop->name);
        });

        static::updating(function (Shop $shop) {
            $shop->slug = Str::slug($shop->name);
        });
    }

    public function image(): hasOne
    {
        return $this->hasOne(Image::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)
            ->withPivot([
                'price'
            ])
            ->withTimestamps();
    }
}
