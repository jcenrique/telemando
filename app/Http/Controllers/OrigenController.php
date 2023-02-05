<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrigenRequest;
use App\Http\Requests\UpdateOrigenRequest;
use App\Models\Origen;

class OrigenController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrigenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrigenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Origen  $origen
     * @return \Illuminate\Http\Response
     */
    public function show(Origen $origen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Origen  $origen
     * @return \Illuminate\Http\Response
     */
    public function edit(Origen $origen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrigenRequest  $request
     * @param  \App\Models\Origen  $origen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrigenRequest $request, Origen $origen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Origen  $origen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Origen $origen)
    {
        //
    }
}
