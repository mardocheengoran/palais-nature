<?php

namespace App\Models;

use App\Models\Article;
use App\Models\ArticleFlash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Flash extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia, Sluggable, SoftDeletes, LogsActivity;
    protected static $logFillable = true;

    public function getActivitylogOptions(): LogOptions{return LogOptions::defaults()->logOnly(['*']);}

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'rank',
        'slug',
        'title',
        'subtitle',
        'icon',
        'content',
        'link',
        'link_video',
        'status',
        'price_discount',
        'limit_at',
        'user_created',
        'user_updated',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean',
        'price_discount' => 'double',
        'limit_at' => 'datetime',
        'user_created' => 'integer',
        'user_updated' => 'integer',


    ];

    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'flashes',
                'field' => 'code',
                'length' => 8,
                'prefix' => 'VF',
                'reset_on_prefix_change' => false,
            ]);
        });
        self::creating(function ($model) {
            $model->user_created = auth()->user()->id;
        });
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(368)
        ->height(232)
        ->sharpen(10);

        $this->addMediaConversion('normal')
        ->width(800)
        ->height(800);

        $this->addMediaConversion('conversion')
        ->quality(80)
        ->withResponsiveImages();
    }
    public function userCreated() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function userUpdated() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_updated');
    }

    public function articles() : BelongsToMany
    {
        return $this->belongsToMany(Article::class)
        ->withPivot('user_created', 'user_updated', 'price_discount', 'price_new')
        ->withTimestamps();
    }

    public function articleflashes() : HasMany
    {
        return $this->hasMany(ArticleFlash::class);
    }
}
