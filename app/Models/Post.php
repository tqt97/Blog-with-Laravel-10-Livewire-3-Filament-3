<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'title',
    // ];
    protected $casts = [
        'published_at' => 'datetime',
    ];


    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publishedDiffForHumans()
    {
        return $this->published_at->diffForHumans();
    }

    /**
     * Returns an estimated reading time in a string
     * @param  string $content the content to be read
     * @param int $wpm
     * @return string estimated read time eg. 1 minute, 30 seconds
     **/
    private function getEstimateReadingTime($content, $wpm = 200)
    {

        $wordCount = str_word_count(strip_tags($content));

        $minutes = (int) floor($wordCount / $wpm);
        $seconds = (int) floor($wordCount % $wpm / ($wpm / 60));

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
                $value = $this->getEstimateReadingTime($attributes['body']);

                return $value;
            }
        );
    }

    public function getExcerpt()
    {
        return Str::limit(strip_tags($this->body), 100, '...');
    }
}
