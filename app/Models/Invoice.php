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

class Invoice extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
    public function getActivitylogOptions(): LogOptions{return LogOptions::defaults()->logOnly(['*']);}


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'content',
        'type',
        'quantity',
        'price_ht',
        'price_tax',
        'price_delivery',
        'price_discount',
        'price_final',
        'planned_at',
        'exacted_at',
        'ip',
        'status',
        'relay_id',
        'delivery_mode_id',
        'payment_method_id',
        'deliveryman_id',
        'address_id',
        'state_id',
        'customer_id',
        'commercial_id',
        'setting_id',
        'user_created',
        'user_updated',
        'supplier_id',
        'parent_id',
        'benefit',
        'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'quantity' => 'double',
        'price_ht' => 'double',
        'price_tax' => 'double',
        'price_delivery' => 'double',
        'price_discount' => 'double',
        'price_final' => 'double',
        'planned_at' => 'datetime',
        'exacted_at' => 'datetime',
        'status' => 'boolean',
        'relay_id' => 'integer',
        'delivery_mode_id' => 'integer',
        'payment_method_id' => 'integer',
        'deliveryman_id' => 'integer',
        'address_id' => 'integer',
        'state_id' => 'integer',
        'customer_id' => 'integer',
        'commercial_id' => 'integer',
        'setting_id' => 'integer',
        'user_created' => 'integer',
        'user_updated' => 'integer',
        'benefit' => 'double',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'invoices',
                'field' => 'code',
                'length' => 8,
                'prefix' => 'IN-',
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

    public function articles()
    {
        return $this->belongsToMany(Article::class)
        ->withPivot('board','benefit','price', 'price_total', 'quantity', 'options', 'user_id', 'created_at', 'updated_at')
        ->withTimestamps();
    }

    public function states()
    {
        return $this->belongsToMany(Parameter::class, 'states')
        ->withPivot('user_created', 'user_updated', 'status')
        ->withTimestamps();
    }

    public function relay()
    {
        return $this->belongsTo(Article::class);
    }

    public function deliveryMode()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function deliveryman()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function state()
    {
        return $this->belongsTo(Parameter::class)/*
        ->where([
            'type_parameter_id' => 22,
        ]) */;
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function commercial()
    {
        return $this->belongsTo(User::class);
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class);
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class);
    }

    public function childrens()
    {
        return $this->hasMany(Invoice::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Invoice::class, 'id', 'parent_id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
}
