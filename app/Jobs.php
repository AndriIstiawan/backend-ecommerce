<?php

namespace App;

use Moloquent;
use Illuminate\Notifications\Notifiable;

class Jobs extends Moloquent
{
    use Notifiable;
    
    protected $fillable = [];
    protected $table = 'jobs';
}