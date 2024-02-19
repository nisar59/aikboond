<?php

namespace Modules\Donors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Donor extends Authenticatable
{
    use HasFactory;

    protected $table='donors';

    protected $fillable = ['name','phone','pin','dob','blood_group','last_donate_date','image','country_id','state_id','city_id','area_id','town_id', 'address'];
    protected static function newFactory()
    {
        return \Modules\Donors\Database\factories\DonorFactory::new();
    }
}
