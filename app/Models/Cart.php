<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    public $table="cart";

public function products()
{
    return $this->belongsTo(Product::class,'product_id','id');
}
}
