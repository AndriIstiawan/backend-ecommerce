<?php

namespace App;

use Moloquent;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class News extends Moloquent
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'keywords' => 'array'
    ];

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by', '_id');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by', '_id');
    }
}
