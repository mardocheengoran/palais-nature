<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\Sluggable;

class Discount extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Sluggable, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
    public function getActivitylogOptions(): LogOptions{return LogOptions::defaults()->logOnly(['*']);}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'title',
        'subtitle',
        'slug',
        'content',
        'type',
        'percent',
        'amount',
        'min',
        'limit_at',
        'customer_id',
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
        'customer_id' => 'integer',
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
                'table' => 'discounts',
                'field' => 'code',
                'length' => 6,
                'prefix' => 'DC',
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

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class);
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class);
    }
}
