<?php

namespace App;

use Moloquent;
use Illuminate\Database\Eloquent\Model;

class Segment extends Moloquent
{
    protected $table = 'segment_products';
    protected $guarded = [];

    /**
     * Segment belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
    	// belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
    	return $this->belongsTo(User::class, 'created_by', '_id');
    }
}

