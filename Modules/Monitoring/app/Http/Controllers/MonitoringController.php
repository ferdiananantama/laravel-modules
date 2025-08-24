<?php

namespace Modules\Monitoring\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Monitoring\Models\Monitoring;
use Modules\MasterLocation\Models\MasterLocation;
use Modules\Monitoring\Export\MonitoringExport as ExportMonitoringExport;
use Modules\Monitoring\Import\MonitoringImport;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Monitoring::with('location');
        $locations = MasterLocation::all();
        if ($request->filled('search')) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('shift', 'like', '%' . $request->search . '%');
        }

        // ✅ Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('tanggal', $request->date);
        }


        $monitorings = $query->paginate(10)->withQueryString();

        return view('monitoring::index', compact('monitorings', 'locations'));
    }

    public function create()
    {
        $locations = MasterLocation::all();
        return view('monitoring::create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'location_id' => 'required|exists:master_locations,id',
            'shift' => 'required|string',
        ]);
        Monitoring::create($request->all());
        return redirect()->route('monitoring.index')->with('success', 'Monitoring created successfully.');
    }

    public function edit($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        $locations = MasterLocation::all();
        return view('monitoring::edit', compact('monitoring', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'location_id' => 'required|exists:master_locations,id',
            'shift' => 'required|string',
        ]);

        $monitoring = Monitoring::findOrFail($id);
        $monitoring->update($request->all());

        return redirect()->route('monitoring.index')->with('success', 'Monitoring updated successfully.');
    }

    public function destroy($id)
    {
        Monitoring::findOrFail($id)->delete();
        return redirect()->route('monitoring.index')->with('success', 'Monitoring deleted successfully.');
    }

    public function exportExcel(Request $request)
    {
        $date = $request->input('date');

        $fileName = 'monitoring';

        if ($date) {
            $fileName .= "_{$date}";
        }

        $fileName .= '.xlsx';

        return Excel::download(new ExportMonitoringExport($date), $fileName);
    }


    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // ✅ Ambil file dari request
        $file = $request->file('file');

        // ✅ Simpan file ke storage/app/imports untuk arsip
        $path = $file->store('imports');

        // ✅ Import langsung dari file upload (tidak pakai storage_path)
        Excel::import(new MonitoringImport, $file);

        return redirect()->back()->with('success', 'Data monitoring berhasil diimport.');
    }
}
