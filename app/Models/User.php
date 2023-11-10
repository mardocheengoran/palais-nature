<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable, SoftDeletes, HasPermissions, HasRoles, LogsActivity, InteractsWithMedia;
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
        'lang',
        'name',
        'first_name',
        'email',
        'pseudo',
        'phone',
        'address',
        'location',
        'occupation',
        'sex',
        'birth_at',
        'birth_place',
        'bio',
        'email_verified_at',
        'password',
        'status',
        'country_id',
        'parent_id',
        'setting_id',
        'user_created',
        'user_updated',
        'store',
        'city_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'location' => 'array',
        'birth_at' => 'timestamp',
        'email_verified_at' => 'timestamp',
        'status' => 'boolean',
        'country_id' => 'integer',
        'parent_id' => 'integer',
        'setting_id' => 'integer',
        'user_created' => 'integer',
        'user_updated' => 'integer',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'fullname'
            ]
        ];
    }

    public function getFullnameAttribute(): string
    {
        return $this->name.' '.$this->first_name;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'users',
                'field' => 'code',
                'length' => 7,
                'prefix' => 'US',
                'reset_on_prefix_change' => false,
            ]);
        });
        self::creating(function ($model) {
            //$model->user_created = auth()->user()->id;
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
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'id', 'parent_id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // Panier d'un user
    public function cart()
    {
        return $this->hasMany(Invoice::class, 'customer_id')
        ->whereHas('states', function($q){
            $q->where('parameters.id', 47)
            ->whereNotNull('states.status');
        })
        //->whereIn('state_id', [47])
        ->orderBy('created_at', 'desc');
    }

    // Liste des articles d'un fournisseur
    public function articles()
    {
        return $this->hasMany(Article::class, 'supplier_id');
    }

    // Panier d'un user
    public function invoices_check()
    {
        return $this->hasMany(Invoice::class, 'customer_id')
        //->whereIn('state_id', [48, 49, 50, 51])
        ->whereHas('states', function($q){
            $q->whereIn('parameters.id', [48])
            /* ->whereNotNull('states.status') */;
        })
        ->orderBy('created_at', 'desc');;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(Parameter::class, 'city_id');
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
}
