<?php

namespace Modules\Donors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\AddressesAndTowns\Entities\AddressesAndTowns;
use Modules\Cities\Entities\Cities;
use Modules\Areas\Entities\Areas;
use App\Models\States;

class Donor extends Authenticatable
{
    use HasFactory;

    protected $table='donors';

    protected $fillable = ['user_id','name','phone','pin','dob','blood_group','last_donate_date','image','country_id','state_id','city_id','area_id','town_id', 'address','status'];
    protected $with=['state', 'city','area','town'];

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

    public function area()
    {
       return $this->hasOne(Areas::class, 'id', 'area_id');
    }

    public function town()
    {
       return $this->hasOne(AddressesAndTowns::class, 'id', 'town_id');
    }


}
