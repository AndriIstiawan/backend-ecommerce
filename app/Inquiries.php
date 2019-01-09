<?php

namespace App;

use Moloquent;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Inquiries extends Moloquent
{
    use Notifiable;
    use SoftDeletes;
    
    protected $fillable = [];
    protected $table = 'inquiries';
}
