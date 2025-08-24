<?php

namespace Modules\MasterLocation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Hours extends Model
{
    protected $fillable = ['name', 'created_by', 'updated_by'];

    protected static function boot()
    {
        parent::boot();

        // saat create
        static::creating(function ($model) {
            if (Session::has('auth_inspection_form')) {
                $userNik = Session::get('auth_inspection_form.nik');
                $model->created_by = $userNik;
                $model->updated_by = $userNik;
            }
        });

        // saat update
        static::updating(function ($model) {
            if (Session::has('auth_inspection_form')) {
                $userNik = Session::get('auth_inspection_form.nik');
                $model->updated_by = $userNik;
            }
        });
    }
}
