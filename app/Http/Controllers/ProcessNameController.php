<?php

namespace App\Http\Controllers;

use App\Models\ProcessName;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProcessNameRequest;
use App\Http\Requests\UpdateProcessNameRequest;

class ProcessNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $process_names = ProcessName::query()->limit(100)->get();
        return view('master-data.process-name', [
            'process_names' => $process_names
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
            'process_name' => ['required']
        ]);

        // Store input data
        $process_name = ProcessName::create($request->only('process_name', 'updated_at'));
        return response()->json([
            'message' => 'New Process Name added successfully',
            'processName' => $process_name
        ]);
        return redirect('/master-data/process-name');
    }

    public function getAll()
    {
        // $ProcessNames = ProcessName::all();
        $ProcessNames = ProcessName::orderBy('id', 'asc')->get();
        return response()->json($ProcessNames);
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
    public function edit(ProcessName $process_name)
    {
        return response()->json($process_name);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProcessName $process_name)
    {
        $process_name->update($request->all());
        return response()->json([
            'message' => 'Process Name updated successfully',
            'processName' => $process_name
        ]);
        return redirect('/master-data/process-name');
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
            $process_name = ProcessName::findOrFail($id);
            $process_name->delete();
            return response()->json(['success' => true, 'message' => 'Process Name deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting Process Name'], 500);
        }
    }
}
