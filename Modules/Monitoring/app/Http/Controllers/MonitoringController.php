<?php

namespace Modules\Monitoring\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Monitoring\Models\Monitoring;
use Modules\MasterLocation\Models\MasterLocation;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitorings = Monitoring::with('location')->paginate(10);
        $locations = MasterLocation::all(); // tambahkan ini
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
}
