<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputProduction;
use App\Models\TableProduction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInputProductionRequest;
use App\Http\Requests\UpdateInputProductionRequest;

class InputProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('input-report/production');
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
        // dd( $request);
        $validatedData = $request->validate([
            'reporter' => 'required | string',
            'group' => 'required | string',
            'date' => 'required | date',
            'shift' => 'required | string',
            'start_time' => 'required',
            'finish_time' => 'required',
            'total_prod_time' => 'required | string',
            'model' => 'required | string',
            'model_year' => 'nullable',
            'spm' => 'required | string',
            'item_name' => 'required | string',
            'coil_no' => 'required | string',
            'plan_a' => 'required | string',
            'plan_b' => 'required | string',
            'ok_a' => 'required | string',
            'ok_b' => 'required | string',
            'rework_a' => 'required | string',
            'rework_b' => 'required | string',
            'scrap_a' => 'required | string',
            'scrap_b' => 'required | string',
            'sample_a' => 'required | string',
            'sample_b' => 'required | string',
            'rework_exp' => 'nullable',
            'scrap_exp' => 'nullable',
            'trial_sample_exp' => 'nullable'
        ]);

        // dd($validatedData);
        // InputProduction::create($validatedData);
        TableProduction::create($validatedData);

        return redirect('/input-report/production')->with('success', 'Production data saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(InputProduction $inputProduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InputProduction $inputProduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInputProductionRequest $request, InputProduction $inputProduction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InputProduction $id)
    {
        $inputProduction = InputProduction::findOrFail($id);
        $inputProduction->delete();

        return response()->json(null, 204);
    }
}
