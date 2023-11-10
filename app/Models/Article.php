<?php

namespace App\Models;

use App\Models\Flash;
use App\Models\Flashe;

use App\Models\Parameter;
use App\Models\ArticleFlash;
use Carbon\Carbon;
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


class Article extends Model implements HasMedia
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
        'rank',
        'slug',
        'title',
        'subtitle',
        'icon',
        'content',
        'link',
        'link_video',
        'resume',
        'address',
        'location',
        'other',
        'start_at',
        'end_at',
        'antidated',
        'price_buy',
        'price_new',
        'price_old',
        'quantity',
        'status',
        'enable',
        'periodicite',
        'surface',
        'number_piece',
        'bathroom',
        'stage',
        'parking',
        'level',
        'experience',
        'number_job',
        'number_place',
        'luggage',
        'door',
        'air_conditioner',
        'city_id',
        'property_id',
        'offer_id',
        'contract_id',
        'fuel_id',
        'transmission_id',
        'brand_id',
        'available_id',
        'rubric_id',
        'audience_id',
        'setting_id',
        'parent_id',
        'user_created',
        'user_updated',
        'published_at',
        'deleted_at',
        'created_at',
        'updated_at',
        'supplier_id',
        'active_size',
        'category1',
        'category2',
        'category3',
        'board',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'location' => 'array',
        'equipements' => 'array',
        'other' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'antidated' => 'datetime',
        'price_buy' => 'double',
        'price_new' => 'double',
        'price_old' => 'double',
        'quantity' => 'double',
        'status' => 'boolean',
        'enable' => 'boolean',
        // 'rubric_id' => 'integer',
        'audience_id' => 'integer',
        'setting_id' => 'integer',
        'parent_id' => 'integer',
        'user_created' => 'integer',
        'user_updated' => 'integer',
        'published_at' => 'datetime',
        'category1' => 'integer',
        'category2' => 'integer',
        'category3' => 'integer',
        'board' => 'double',
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
                'table' => 'articles',
                'field' => 'code',
                'length' => 8,
                'prefix' => 'AR',
                'reset_on_prefix_change' => false,
            ]);
        });
        self::creating(function ($model) {
            $model->user_created = auth()->user()->id;
            $model->setting_id = 1;
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

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class);
    }

    public function equipments()
    {
        return $this->belongsToMany(Parameter::class)
        ->wherePivot('type', 'equipment')
        ->withPivot('type', 'user_created', 'user_updated')
        ->withPivotValue('type', 'equipment')
        ->withTimestamps();
    }

    public function jobs()
    {
        return $this->belongsToMany(Parameter::class)
        ->wherePivot('type', 'job')
        ->withPivot('type', 'user_created', 'user_updated')
        ->withPivotValue('type', 'job')
        ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Parameter::class)
        ->wherePivot('type', 'category')
        ->withPivot('type', 'user_created', 'user_updated' )
        ->withPivotValue('type', 'category')
        ->withTimestamps();
    }

    public function sizes()
    {
        return $this->belongsToMany(Parameter::class)
        ->wherePivot('type', 'size')
        ->withPivot('type', 'user_created', 'user_updated', 'quantity')
        ->withPivotValue('type', 'size')
        ->withTimestamps();
    }

    public function sizes_pivot()
    {
        return $this->hasMany(ArticleParameter::class, 'article_id', 'id')
        ->whereType('size')/*
        ->withDefault('type', 'size') */;
    }

    public function supplier()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function property()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function fuel()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function brand()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function available()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function offer()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function contract()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)
        ->withPivot('board','benefit','price', 'price_total', 'quantity', 'options', 'user_id', 'created_at', 'updated_at')
        ->withTimestamps();
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }

    public function rubric()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function audience()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function parent()
    {
        return $this->belongsTo(Article::class);
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class);
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class);
    }
    public function signals()
    {
        return $this->hasMany(Signal::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function category1()
    {
        return $this->belongsTo(Parameter::class, 'category1');
    }

    public function category2()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function category3()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function flashes()
    {
        return $this->belongsToMany(Flash::class)
        ->withPivot('user_created', 'user_updated', 'price_discount', 'price_new')
        ->withTimestamps();
    }

    public function flashes_current()
    {
        return $this->belongsToMany(Flash::class)
        ->whereDate('limit_at', '>', Carbon::now())
        ->withPivot('user_created', 'user_updated', 'price_discount', 'price_new')
        ->withTimestamps();
    }

    public function articleflashes() : HasMany
    {
        return $this->hasMany(ArticleFlash::class);
    }
}
