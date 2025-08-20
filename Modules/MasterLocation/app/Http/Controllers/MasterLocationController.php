<?php

namespace Modules\MasterLocation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterLocation\Models\MasterLocation;

class MasterLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $user = session('user');
        // return view('monitoring::index', compact('user'));

        $query = MasterLocation::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $locations = $query->paginate(10)->withQueryString();
        return view('masterlocation::index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        MasterLocation::create($request->only('name'));
        return redirect()->back()->with('success', 'Location added successfully.');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:master_location,name,' . $id,
            ]);

            $location = MasterLocation::findOrFail($id);
            $location->update([
                'name' => $request->input('name'),
            ]);

            return redirect()->back()->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update location: ' . $e->getMessage());
        }
    }



    public function destroy($id)
    {
        MasterLocation::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Location deleted successfully.');
    }
}
