<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['pr_name', 'base_price' ,'status'];

    public function stock()
    {
         return $this->hasMany(Stock::class, 'pr_id', 'pr_id');
    }
}
