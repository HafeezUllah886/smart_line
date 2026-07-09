<?php

namespace App\Http\Controllers;

use App\Models\drivers;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = drivers::all();

        return view('settings.drivers', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'unique:drivers,name',
            ],
            [
                'name.unique' => 'Driver already Existing',
            ]
        );

        drivers::create($request->all());

        return back()->with('success', 'Driver Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(drivers $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(drivers $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'unique:drivers,name,'.$id,
            ],
            [
                'name.unique' => 'Driver already Existing',
            ]
        );

        $driver = drivers::find($id);
        $driver->update($request->all());

        return back()->with('success', 'Driver Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(drivers $driver)
    {
        //
        $driver->delete();

        return back()->with('success', 'Driver Deleted');
    }
}
