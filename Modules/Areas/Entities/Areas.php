<?php

namespace Modules\Areas\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Areas extends Model
{
    use HasFactory;

    protected $fillable = ['country_id','state_id','city_id','name','nearest_place'];
    protected $table='areas';
    
    protected static function newFactory()
    {
        return \Modules\Areas\Database\factories\AreasFactory::new();
    }
}
