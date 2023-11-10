<?php

namespace App\Models;

use App\Models\User;
use App\Models\Flash;
use App\Models\Article;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleFlash extends Model
{
    use HasFactory,InteractsWithMedia, Sluggable, SoftDeletes, LogsActivity;
    protected static $logFillable = true;

    public function getActivitylogOptions(): LogOptions{return LogOptions::defaults()->logOnly(['*']);}

    protected $table = 'article_flash';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'flash_id',
        'price_discount',
        'user_created',
        'user_updated',
        'price_new',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
       'article_id' => 'integer',
       'flash_id' => 'integer',
       'price_discount' => 'double',
       'price_new' => 'double',
    ];

    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function userCreated() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function userUpdated() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_updated');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function flash()
    {
        return $this->belongsTo(Flash::class);
    }

}
