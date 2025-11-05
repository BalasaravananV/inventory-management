<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['pr_id', 'wh_id', 'quantity', 'expires_at','status'];

   public function product()
{
    return $this->belongsTo(Product::class, 'pr_id', 'pr_id');
}


    public function warehouse()
    {
       return $this->belongsTo(Warehouse::class, 'wh_id', 'wh_id');
    }
}
