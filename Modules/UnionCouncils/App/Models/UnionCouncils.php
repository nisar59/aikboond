<?php

namespace Modules\UnionCouncils\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UnionCouncils\Database\factories\UnionCouncilsFactory;

class UnionCouncils extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['state_id','city_id','name'];
    protected $table='union_councils';
    
    protected static function newFactory(): UnionCouncilsFactory
    {
        //return UnionCouncilsFactory::new();
    }
}
