<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $primaryKey = 'wh_id';

    protected $fillable = ['name', 'latitude', 'longitude','status'];

    public function stock()
    {
         return $this->hasMany(Stock::class, 'wh_id', 'wh_id');
    }
}
