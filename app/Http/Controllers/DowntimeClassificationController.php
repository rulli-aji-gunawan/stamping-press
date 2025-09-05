<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DowntimeClassification;
use App\Http\Requests\StoreDowntimeClassificationRequest;
use App\Http\Requests\UpdateDowntimeClassificationRequest;

class DowntimeClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dt_classifications = DowntimeClassification::query()->limit(100)->get();
        return view('master-data.downtime-classification', [
            'dt_classifications' => $dt_classifications
        ]);
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
        // Validation
        $request->validate([
            'downtime_classification' => ['required']
        ]);

        // Store input data
        $dt_classification = DowntimeClassification::create($request->only('downtime_classification', 'updated_at'));
        return response()->json([
            'message' => 'New Downtime Classification added successfully',
            'DowntimeClassification' => $dt_classification
        ]);
        return redirect('/master-data/downtime-classification');
    }

    public function getAll()
    {
        $DowntimeClassifications = DowntimeClassification::orderBy('id', 'asc')->get();
        return response()->json($DowntimeClassifications);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DowntimeClassification $dt_classification)
    {
        return response()->json($dt_classification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DowntimeClassification $dt_classification)
    {
        $dt_classification->update($request->all());
        return response()->json([
            'message' => 'Downtime Classification updated successfully',
            'DowntimeClassification' => $dt_classification
        ]);
        return redirect('/master-data/downtime-classification');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id)
    {
        try {
            $dt_classification = DowntimeClassification::findOrFail($id);
            $dt_classification->delete();
            return response()->json(['success' => true, 'message' => 'Downtime Classification deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting Downtime Classification'], 500);
        }
    }
}
