<?php

namespace App\Models;

use App\Models\Article;
use App\Models\TypeParameter;

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
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Parameter extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Sluggable, SoftDeletes, LogsActivity, HasPermissions, HasRoles;
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
        'class',
        'color',
        'content',
        'address',
        'location',
        'component',
        'component_detail',
        'field',
        'grid',
        'status',

        'link',
        'submenu',
        'ecommerce',
        'board',
        'link_id',
        'link_article_id',
        'item_type_parameter_id',
        'item_rubric_id',

        'type_parameter_id',
        'parent_id',
        'setting_id',
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
        'location' => 'array',
        'field' => 'array',
        'board' => 'double',
        'status' => 'boolean',
        'type_parameter_id' => 'integer',
        'rank' => 'integer',
        'parent_id' => 'integer',
        'setting_id' => 'integer',
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
                'table' => 'parameters',
                'field' => 'code',
                'length' => 6,
                'prefix' => 'PA',
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

    public function childrens()
    {
        return $this->hasMany(Parameter::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Parameter::class, 'parent_id');
    }

    public function parent_filament()
    {
        return $this->belongsTo(Parameter::class, 'parent_id');
    }

    public function typeParameter()
    {
        return $this->belongsTo(TypeParameter::class);
    }

    public function item_type_parameter()
    {
        return $this->belongsTo(TypeParameter::class, 'item_type_parameter_id');
    }

    //
    public function item_rubric()
    {
        return $this->belongsTo(Parameter::class, 'item_rubric_id');
    }

    public function link_rubric()
    {
        return $this->belongsTo(Parameter::class, 'link_id');
    }

    public function link_article()
    {
        return $this->belongsTo(Article::class, 'link_article_id');
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function products()
    {
        return $this->belongsToMany(Article::class)
        ->whereStatus(1)
        ->wherePivot('type', 'category')
        ->withPivot('type', 'user_created', 'user_updated')
        ->withTimestamps();
    }

    public function sizes()
    {
        return $this->belongsToMany(Article::class)
        ->wherePivot('type', 'size')
        ->withPivot('type', 'user_created', 'user_updated')
        ->withTimestamps();
    }

    public function communes()
    {
        return $this->hasMany(Article::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'rubric_id');
    }

    public function offers()
    {
        return $this->hasMany(Article::class, 'offer_type_id');
    }

    public function properties()
    {
        return $this->hasMany(Article::class, 'property_type_id');
    }

    public function rubrics()
    {
        return $this->hasMany(Article::class, 'rubric_id');
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
