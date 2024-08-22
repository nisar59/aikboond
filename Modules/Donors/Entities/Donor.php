<?php

namespace Modules\Donors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use Modules\Cities\Entities\Cities;
 use App\Models\States;

class Donor extends Authenticatable
{
    use HasFactory;

    protected $table='donors';

    protected $fillable = ['user_id','name','phone','pin','dob','blood_group','last_donate_date','image','country_id','state_id','city_id','ucouncil_id','address','status'];
    protected $with=['state', 'city'];

    protected static function newFactory()
    {
        return \Modules\Donors\Database\factories\DonorFactory::new();
    }


    public function state()
    {
       return $this->hasOne(States::class, 'id', 'state_id');
    }

    public function city()
    {
       return $this->hasOne(Cities::class, 'id', 'city_id');
    }
     

}
