<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable =[
        'name','lastLocation','BU','OU'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function transfer(){
        return $this->hasOne(Transfer::class);
    }
}
