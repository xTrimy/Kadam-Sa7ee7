<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')){
            $doctors = Doctor::with('hospital')->get();
        }else{
            $hospital = auth()->user()->hospitals()->first();
            $doctors = $hospital->doctors()->get();
        }
        return view('doctors.view', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitals = Hospital::all();
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospitals = auth()->user()->hospitals()->get();
        }
        return view('doctors.add', compact('hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:doctors',
                'phone' => 'nullable|string',
                'hospital' => 'required|integer|exists:hospitals,id',
            ]
        );
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospital = auth()->user()->hospitals()->first();
            $request->hospital = $hospital->id;
        } 
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'hospital_id' => $request->hospital,
        ]);
        
        return redirect()->back()->with('success', __('Doctor added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Doctor::with('hospital')->find($id);
        return view('doctors.view', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = Doctor::find($id);
        $hospitals = Hospital::all();
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospitals = auth()->user()->hospitals()->get();
        }
        return view('doctors.add', compact('doctor','hospitals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:doctors',
                'phone' => 'nullable|string',
                'hospital' => 'required|integer|exists:hospitals,id',
            ]
        );
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospital = auth()->user()->hospitals()->first();
            $request->hospital = $hospital->id;
        } 
        $doctor = Doctor::find($id);
        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->phone = $request->phone;
        $doctor->hospital_id = $request->hospital;
        $doctor->save();
        return redirect()->back()->with('success', __('Doctor updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();
        return redirect()->route('doctors.index');
    }
}
