<?php

namespace App;

use Moloquent;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class PromoSlider extends Moloquent
{
    use Notifiable;
	use SoftDeletes;
    
    protected $fillable = [
    ];
}
