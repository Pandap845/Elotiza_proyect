<?php

namespace App\Http\Controllers;

use App\Models\Elote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EloteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $elotes = Elote::all();
        return Inertia::render('OrderElotes', ['elotes' => $elotes]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Elote $elote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Elote $elote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Elote $elote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Elote $elote)
    {
        //
    }
}
