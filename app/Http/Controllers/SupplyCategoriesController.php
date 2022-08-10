<?php

namespace App\Http\Controllers;

use App\Models\SupplyCategory;
use Illuminate\Http\Request;

class SupplyCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supply_categories.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supply_category = new SupplyCategory();
        $supply_category->name = $request->name;
        $supply_category->save();
        return redirect()->back()->with('success', __('Category added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplyCategory  $supplyCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyCategory $supplyCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplyCategory  $supplyCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplyCategory $supplyCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplyCategory  $supplyCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplyCategory $supplyCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplyCategory  $supplyCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplyCategory $supplyCategory)
    {
        //
    }
}
