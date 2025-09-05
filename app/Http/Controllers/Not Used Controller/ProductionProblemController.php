<?php

namespace App\Http\Controllers;

use App\Models\ProcessName;
use Illuminate\Http\Request;
use App\Models\InputProduction;
use App\Models\ProductionProblem;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\DowntimeCategory;
use Illuminate\Support\Facades\Validator;


class ProductionProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('input-report/production');
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
        $validator = Validator::make($request->all(), [
            'production_problems' => 'required|array',
            'production_problems.*.time_from' => 'required',
            'production_problems.*.time_until' => 'required',
            'production_problems.*.total_time' => 'required',
            'production_problems.*.process_name' => 'required',
            'production_problems.*.dt_category' => 'required',
            'production_problems.*.downtime_type' => 'required',
            'production_problems.*.dt_classification' => 'required',
            'production_problems.*.problem_description' => 'required',
            'production_problems.*.root_cause' => 'required',
            'production_problems.*.counter_measure' => 'required',
            'production_problems.*.pic' => 'nullable',
            'production_problems.*.status' => 'nullable',
        ]);

        Log::info('Received production data:', $request->all());

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Log::info('Starting to save problems');
            foreach ($request->production_problems as $problemData) {
                $processName = ProcessName::find($problemData['process_name'])->process_name;
                $dtCategory = DowntimeCategory::find($problemData['dt_category'])->dt_category;
                Log::info('Saving problem:', $problemData);
                ProductionProblem::create([
                    'time_from' => $problemData['time_from'],
                    'time_until' => $problemData['time_until'],
                    'total_time' => $problemData['total_time'],
                    'process_name' => $processName,
                    'dt_category' => $dtCategory,
                    'downtime_type' => $problemData['downtime_type'],
                    'dt_classification' => $problemData['dt_classification'],
                    'problem_description' => $problemData['problem_description'],
                    'root_cause' => $problemData['root_cause'],
                    'counter_measure' => $problemData['counter_measure'],
                    'pic' => $problemData['pic'],
                    'status' => $problemData['status'],
                ]);
            }

            return response()->json(['message' => 'Data berhasil disimpan'], 201);
        } catch (\Exception $e) {
            Log::error('Error saving problems:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productionProblem = ProductionProblem::findOrFail($id);
        $productionProblem->delete();

        return response()->json(null, 204);
    }
}
