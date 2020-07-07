<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = [
        'type', 'amount'
    ];

    public function doses()
    {
        return $this->hasMany('App/Dose');
    }
}
