<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dose extends Model
{
    protected $fillable = [
        'user_id', 'drink_id', 'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function drink()
    {
        return $this->belongsTo('App\Drink');
    }
}
