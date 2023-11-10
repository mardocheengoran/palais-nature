<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleParameter extends Model
{
    use HasFactory;

    protected $table = 'article_parameter';

    protected $fillable = [
        'article_id',
        'parameter_id',
        'user_created',
        'user_updated',
        'type',
        'quantity',
        'benefit'
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class);
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class)->withDefault([
            'type' => 'size',
        ]);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
