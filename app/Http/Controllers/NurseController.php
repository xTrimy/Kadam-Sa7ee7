<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Nurse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')) {
            $nurses = Nurse::with('hospital')->get();
        } else {
            $hospital = auth()->user()->hospitals()->first();
            $nurses = $hospital->nurses()->get();
        }
        return view('nurses.view', compact('nurses'));
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
        return view('nurses.add', compact('hospitals'));
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
                'email' => 'nullable|string|email|max:255|unique:nurses',
                'phone' => 'nullable|string',
                'hospital' => 'required|integer|exists:hospitals,id',
            ]
        );
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospital = auth()->user()->hospitals()->first();
            $request->hospital = $hospital->id;
        }
        $nurse = Nurse::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'hospital_id' => $request->hospital,
        ]);

        return redirect()->back()->with('success', __('Nurse added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nurse = Nurse::with('hospital')->find($id);
        return view('nurses.view', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nurse = Nurse::find($id);
        $hospitals = Hospital::all();
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospitals = auth()->user()->hospitals()->get();
        }
        return view('nurses.add', compact('doctor', 'hospitals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:nurses',
                'phone' => 'nullable|string',
                'hospital' => 'required|integer|exists:hospitals,id',
            ]
        );
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) {
            $hospital = auth()->user()->hospitals()->first();
            $request->hospital = $hospital->id;
        }
        $nurse = Nurse::find($id);
        $nurse->name = $request->name;
        $nurse->email = $request->email;
        $nurse->phone = $request->phone;
        $nurse->hospital_id = $request->hospital;
        $nurse->save();
        return redirect()->back()->with('success', __('Nurse updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nurse = Nurse::find($id);
        $nurse->delete();
        return redirect()->route('nurses.index');
    }
}
