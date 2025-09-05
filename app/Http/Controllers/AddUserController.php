<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddUserController extends Controller
{
    public function index()
    {
        return view('master-data.add-user');
    }


    public function store(Request $request)
    {
        dd($request);
        // return view('master-data.add-user');
        // User::create($request);
        // return redirect('master-data/user');
    }
}
