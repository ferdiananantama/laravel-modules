<?php

namespace Modules\MasterLocation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\MasterLocation\Database\Factories\MasterLocationFactory;

class MasterLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'master_locations';
    protected $fillable = ['name'];

    // protected static function newFactory(): MasterLocationFactory
    // {
    //     // return MasterLocationFactory::new();
    // }
}
