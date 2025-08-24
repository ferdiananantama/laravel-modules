<?php

namespace Modules\Monitoring\Export;

use Modules\Monitoring\Models\Monitoring;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonitoringExport implements FromCollection, WithHeadings
{
    protected $date;

    public function __construct($date = null)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $query = Monitoring::with('location');

        if ($this->date) {
            $query->whereDate('tanggal', [$this->date]);
        }

        return $query->get()->map(function ($item) {
            return [
                'Tanggal'     => $item->tanggal,
                'Location'    => $item->location->name ?? '-',
                'Shift'       => $item->shift,
                'Work Hours'  => $item->work_hours,
                'Jumlah User' => $item->jumlah_user,
                'Output'      => $item->output,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Location', 'Shift', 'Work Hours', 'Jumlah User', 'Output'];
    }
}
