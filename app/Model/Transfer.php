<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable =[
        'location_id','product_id','status'
    ];

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
