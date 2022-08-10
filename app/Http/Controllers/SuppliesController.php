<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

class SuppliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplies = Supply::all();
        return view('supplies.view', compact('supplies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Models\SupplyCategory::all();
        return view('supplies.add', compact('categories'));
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
            'name' => 'required|unique:supplies,name',
            'category_id' => 'required|exists:supply_categories,id',
            'quantity' => 'required|integer',
        ]);
        $supply = new Supply();
        $supply->name = $request->name;
        $supply->supply_category_id = $request->category_id;
        $supply->quantity = $request->quantity;
        $supply->price = $request->price;
        $supply->created_by = auth()->user()->id;
        $supply->save();

        return redirect()->back()->with('success', __('Supply added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        //
    }

    public function edit_quantity(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'id'=> 'required|exists:supplies,id',
        ]);
        $supply = Supply::find($request->id);
        $supply->quantity = $request->quantity;
        $supply->save();
        return redirect()->back()->with('success', __('Quantity updated successfully'));
    }

    public function transfer($type,$id=null){
        $hospital = null;
        $patient = null;
        if($type == 'hospital'){
            $supplies = Supply::all();
            if(isset($id)){
                $hospital = \App\Models\Hospital::with('supplies')->find($id);
            }
        }else if($type == 'patient'){
            $supplies = Supply::all();
            if (isset($id)) {
                $patient = \App\Models\Patient::with('supplies')->find($id);
            }
        }else{
            return abort(404);
        }
        return view('supplies.transfer_to', compact('supplies','hospital', 'patient'));
    }

    public function transfer_store(Request $request, $type, $id = null)
    {
        $request->validate([
            'supply_id' => 'required|array',
            'supply_id.*' => 'required|exists:supplies,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer',
            'type'=>'required|in:hospital,patient',
            'id'=>'required',
        ]);
        $errors = [];
        if($type == 'hospital'){
            $hospital = \App\Models\Hospital::find($id);
            $supplies_ids = $request->supply_id;
            $quantities = $request->quantity;
            $supplies_ids = array_combine($supplies_ids, $quantities);
            foreach ($supplies_ids as $supply_id => $quantity) {
                if($quantity == 0){
                    continue;
                }
                $supply = Supply::find($supply_id);
                $supply->quantity -= $quantity;
                if ($supply->quantity < 0) {
                    $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                    continue;
                }
                $supply->save();
                $hospital_supply = \App\Models\HospitalSupply::where('supply_id',$supply_id)->where('hospital_id',$id)->first();
                if($hospital_supply == null){
                    $hospital_supply = new \App\Models\HospitalSupply();
                    $hospital_supply->hospital_id = $id;
                    $hospital_supply->supply_id = $supply_id;
                   
                }
                $hospital_supply->quantity += intval($quantity);
                $hospital_supply->save();
                // Add new transaction 
                $transaction = new \App\Models\SupplyTransaction();
                $transaction->hospital_id = $id;
                $transaction->supply_id = $supply_id;
                $transaction->quantity = $quantity;
                $transaction->save();
            }
        }else if($type == 'patient'){
            $patient = \App\Models\Patient::find($id);
            $supplies_ids = $request->supply_id;
            $quantities = $request->quantity;
            $supplies_ids = array_combine($supplies_ids, $quantities);
            foreach ($supplies_ids as $supply_id => $quantity) {
                if ($quantity == 0) {
                    continue;
                }
                $supply = Supply::find($supply_id);
                $supply->quantity -= $quantity;
                if($supply->quantity < 0){
                    $errors [] = __('Supply ":supply" could not be updated. Main stock is not enough',['supply'=>$supply->name]);
                    continue;
                }
                $supply->save();
                $patient_supply = \App\Models\PatientSupply::where('supply_id',$supply_id)->where('patient_id',$id)->first();
                if($patient_supply == null){
                    $patient_supply = new \App\Models\PatientSupply();
                    $patient_supply->patient_id = $id;
                    $patient_supply->supply_id = $supply_id;
                   
                }
                $patient_supply->quantity += intval($quantity);
                $patient_supply->save();
                // Add new transaction 
                $transaction = new \App\Models\SupplyTransaction();
                $transaction->patient_id = $id;
                $transaction->supply_id = $supply_id;
                $transaction->quantity = $quantity;
                $transaction->save();
            }
        }else{
            return abort(404);
        }
        return redirect()->back()->with(
            [
                'success'=>__('Supplies transferred successfully'),
                'supply_errors' => $errors
            ]
        );
    }
}
