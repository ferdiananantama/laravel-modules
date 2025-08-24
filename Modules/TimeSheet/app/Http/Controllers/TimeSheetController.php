<?php

namespace Modules\TimeSheet\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Timesheet\Entities\Timesheet;

class TimeSheetController extends Controller
{
    public function index()
    {
        $date = Carbon::today();

        $start = $date->copy()->setTime(8, 0);
        $end   = $date->copy()->setTime(23, 0);

        while ($start->lte($end)) {
            $times[] = $start->format('H:i');
            $records[] = [
                'time' => $start->format('H:i'),
                'note' => $dummyData[$start->format('H:i')] ?? '',
                'editable_start' => $start->copy(),
                'editable_end'   => $start->copy()->addHour()
            ];
            $start->addHour();
        }

        $dummyData = [
            '08:00' => ['note' => 'Meeting pagi'],
            '09:00' => ['note' => 'Cek mesin produksi'],
            '10:00' => ['note' => 'Input laporan'],
            '12:00' => ['note' => 'Istirahat siang'],
            '15:00' => ['note' => 'Briefing tim'],
            '16:00' => ['note' => 'Cek email dan follow up'],
            '18:00' => ['note' => 'Review pekerjaan'],
            '20:00' => ['note' => 'Lembur dokumentasi'],
            '23:00' => ['note' => 'Persiapan tutup hari'],
        ];

        $records = collect($times)->map(function ($t) use ($dummyData) {
            return [
                'time' => $t,
                'note' => $dummyData[$t]['note'] ?? '',
                'editable_start' => $t,
                'editable_end'   => Carbon::parse($t)->addHour()->format('H:i'),
            ];
        })->values()->toArray();

        return view('timesheet::index', compact('date', 'records'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'time' => 'required',
            'note' => 'nullable|string',
        ]);

        Timesheet::updateOrCreate(
            [
                'date' => now()->toDateString(),
                'time' => $request->time,
            ],
            [
                'note' => $request->note,
                // 'created_by' => auth()->user()->nik ?? auth()->user()->name,
            ]
        );

        return back()->with('success', 'Data berhasil disimpan');
    }
}
