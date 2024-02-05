<?php

namespace Modules\Donors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Donor extends Authenticatable
{
    use HasFactory;

    protected $table='donors';

    protected $fillable = ['id','image','name','password','country_id','state_id','city_id','area_id','address_id', 'age', 'upazila_name', 'blood_group', 'contact_no', 'last_donate_date'];
    protected static function newFactory()
    {
        return \Modules\Donors\Database\factories\DonorFactory::new();
    }
}
