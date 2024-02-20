<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Modules\AddressesAndTowns\Entities\AddressesAndTowns;
use Modules\Cities\Entities\Cities;
use Modules\Areas\Entities\Areas;
use App\Models\States;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'town_id',
        'address',
        
    ];

    protected $with=['state', 'city','area','town'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
