<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Devis extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, /* Sluggable, */ SoftDeletes, LogsActivity;

    protected static $logFillable = true;

    public function getActivitylogOptions(): LogOptions{return LogOptions::defaults()->logOnly(['*']);}

    protected $fillable = [
        'code',
        'entreprise',
        'phone',
        'email',
        'nature',
        'hscode',
        'poids',
        'shipping',
        'conteneur',
        'port',
        'enlevement',
        'dechargement',
        'livraison',
        'commentaire',
        'user_created',
        'user_updated',
    ];

    /* public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'entreprise'
            ]
        ];
    } */

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'devis',
                'field' => 'code',
                'length' => 6,
                'prefix' => 'DE',
                'reset_on_prefix_change' => false,
            ]);
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

    public function userCreated()
    {
        return $this->belongsTo(User::class);
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class);
    }
}
