<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DowntimeCategory;

class DowntimeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $downtime_categories = DowntimeCategory::query()->limit(100)->get();
        return view('master-data.downtime-category', [
            'downtime_categories' => $downtime_categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getDowntimeType($category_id)
    {
        $category = DowntimeCategory::findOrFail($category_id);
        return response()->json(['downtime_type' => $category->downtime_type]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'downtime_name' => ['required'],
            'downtime_type' => ['required'],
        ]);

        // Store input data
        $downtime_categories = DowntimeCategory::create($request->only('downtime_name', 'downtime_type', 'updated_at'));
        return response()->json([
            'message' => 'New Downtime Category added successfully',
            'downtime_categories' => $downtime_categories
        ]);
        return redirect('master-data.downtime-category');
    }

    public function getAll()
    {
        $downtimeCategories = DowntimeCategory::all();
        return response()->json($downtimeCategories);

        // $downtime_categories = DowntimeCategory::orderBy('created_at', 'desc')->get();
        // return response()->json($downtime_categories);
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
    public function edit(DowntimeCategory $downtime_category)
    {
        return response()->json($downtime_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DowntimeCategory $downtime_category)
    {
        $downtime_category->update($request->all());
        return response()->json([
            'message' => 'Downtime Category updated successfully',
            'downtimeCategory' => $downtime_category
        ]);
        return redirect('/master-data/downtime-category');
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
            $downtime_category = DowntimeCategory::findOrFail($id);
            $downtime_category->delete();
            return response()->json(['success' => true, 'message' => 'Downtime Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting Downtime Category'], 500);
        }
    }
}
