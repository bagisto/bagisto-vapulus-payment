<?php

namespace Webkul\Vapulus\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Vapulus\Contracts\Vapulus as VapulusContract;

class Vapulus extends Model implements VapulusContract
{
    public $timestamps = false;
    
    protected $table = 'vapulus_transactions';

    protected $fillable = [
        'transaction_id',
        'order_id',
        'status',
    ];
}