<?php

namespace App;

use Moloquent;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Midtrans_Payment extends Moloquent
{
    protected $table = 'midtrans_payment';
}
