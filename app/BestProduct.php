<?php

namespace App;

use Moloquent;
use Illuminate\Database\Eloquent\Model;

class BestProduct extends Moloquent
{
    protected $tables = 'best_products';
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
