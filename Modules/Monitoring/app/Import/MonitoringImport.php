<?php

namespace Modules\Monitoring\Import;

use Modules\Monitoring\Models\Monitoring;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\MasterLocation\Models\MasterLocation;

class MonitoringImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $location = MasterLocation::where('name', $row['location'])->first();

        return new Monitoring([
            'tanggal'     => $row['tanggal'] ?? null,
            'location_id' => $location?->id, // mapping ke ID
            'shift'       => $row['shift'] ?? null,
            'work_hours'  => $row['work_hours'] ?? null,
            'jumlah_user' => $row['jumlah_user'] ?? null,
            'output'      => $row['output'] ?? null,
        ]);
    }
}
