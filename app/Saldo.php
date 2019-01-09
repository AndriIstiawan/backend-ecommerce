<?php

namespace App;

use Moloquent;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Saldo extends Moloquent
{
    use SoftDeletes;
    protected $table = 'saldo';

    /**
     * This fillable for App\Saldo model
     * You can add new fillable if you needed
     * @var array
     */
    protected $fillable = [
        'member_id',
        'status', // approved, waiting, reject
        'description',
        'nominal'
    ];

    /**
     * Relationship App\Saldo to App\Member
     * @return void
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
