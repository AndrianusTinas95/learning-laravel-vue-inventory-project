<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $fillable =[
        'name'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
