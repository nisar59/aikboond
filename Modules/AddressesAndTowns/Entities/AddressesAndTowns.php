<?php

namespace Modules\AddressesAndTowns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddressesAndTowns extends Model
{
    use HasFactory;

    protected $fillable = ['country_id','state_id','city_id','area_id','name'];
    protected $table='addresses-and-towns';
    
    protected static function newFactory()
    {
        return \Modules\AddressesAndTowns\Database\factories\AddressesAndTownsFactory::new();
    }
}
