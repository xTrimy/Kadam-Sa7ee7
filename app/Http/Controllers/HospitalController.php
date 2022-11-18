<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::withCount('patients')->get();
        return view('hospitals.view', compact('hospitals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hospitals.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>"required|string",
            "address"=>"required|string"
        ]);

        $hospital = new Hospital($request->only(['name', 'address']));
        $hospital->save();

        return redirect()->back()->with('success', __('Hospital added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hospital = Hospital::with('availability_times')->find($id);
        return view('hospitals.add', compact('hospital'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>"required|string",
            "address"=>"required|string"
        ]);
        
        $hospital = Hospital::find($id);
        if($request->has('day')){
            $hospital->availability_times()->delete();
            foreach($request->day as $key => $day){
                if($day == null || $request->from[$key] == null || $request->to[$key] == null){
                    continue;
                }
                $hospital->availability_times()->create([
                    'day' => $day,
                    'start_time' => $request->from[$key],
                    'end_time' => $request->to[$key]
                ]);
            }
        }
        $hospital->update($request->only(['name', 'address']));
        return redirect()->back()->with('success', __('Hospital updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        //
    }
}
