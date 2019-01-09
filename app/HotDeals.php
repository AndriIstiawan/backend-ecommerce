<?php

namespace App;

use Moloquent;
use Illuminate\Database\Eloquent\Model;

class HotDeals extends Moloquent
{
    protected $tables = 'hot_deals';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', '_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', '_id');
    }
}
