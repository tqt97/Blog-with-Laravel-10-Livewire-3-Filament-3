<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, softDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function scopePublished(Builder $query): void
    {
        // $query->whereNotNull('published_at');
        $query->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured', true);
    }

    public function scopeSearch(Builder $query, string $search = ''): void
    {
        $query->where('title', 'like', '%' . $search . '%');
    }

    public function scopePopular(Builder $query): void
    {
        $query->withCount('likes')->orderBy('likes_count', 'desc');
    }

    public function scopeWithCategory(Builder $query, string $category): void
    {
        $query->whereHas('categories', function ($q) use ($category) {
            $q->where('slug', $category);
        });
    }

    public function publishedDiffForHumans()
    {
        return $this->published_at->diffForHumans();
    }

    /**
     * Returns an estimated reading time in a string
     * @param string $content the content to be read
     * @param int $wpm
     * @return string estimated read time e.g 1 minute, 30 seconds
     **/
    private function getEstimateReadingTime(string $content, int $wpm = 200): string
    {

        $wordCount = str_word_count(strip_tags($content));

        $minutes = (int)floor($wordCount / $wpm);
        $seconds = (int)floor($wordCount % $wpm / ($wpm / 60));

        if ($minutes === 0) {
            return $wordCount . " words, " . $seconds . " " . Str::of('second')->plural($seconds) . " to reading";
        } else {
            return $wordCount . " words, " . $minutes . " " . Str::of('minute')->plural($minutes) . " to reading";
        }
    }

    protected function timeToRead(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $this->getEstimateReadingTime($attributes['body']);
            }
        );
    }

    public function getExcerpt(): string
    {
        return Str::limit(strip_tags($this->body), 100, '...');
    }

    public function getThumbnail(): string
    {
        $isUrl = str_contains($this->image, 'http://') || str_contains($this->image, 'https://');
//        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('img/default.png');
        return $isUrl ? $this->image : asset('storage/' . $this->image);
    }
}
