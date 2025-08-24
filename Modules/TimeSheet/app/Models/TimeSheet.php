<?php

namespace Modules\Timesheet\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'timesheets';
    protected $fillable = [
        'date',
        'time',
        'note',
        // 'created_by',
    ];
}
