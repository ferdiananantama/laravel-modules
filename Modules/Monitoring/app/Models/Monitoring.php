<?php

namespace Modules\Monitoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitorings';
    protected $fillable = [
        'tanggal',
        'location_id',
        'shift',
        'work_hours',
        'start_hours',
        'breaktime1',
        'breaktime2',
        'break_duration',
        'end_hours',
        'jumlah_user',
        'output'
    ];

    public function location()
    {
        return $this->belongsTo(\Modules\MasterLocation\Models\MasterLocation::class, 'location_id');
    }
}
