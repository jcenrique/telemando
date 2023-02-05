<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlarmaRequest;
use App\Http\Requests\UpdateAlarmaRequest;
use App\Models\Alarma;

class AlarmaController extends Controller
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
     * @param  \App\Http\Requests\StoreAlarmaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlarmaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alarma  $alarma
     * @return \Illuminate\Http\Response
     */
    public function show(Alarma $alarma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alarma  $alarma
     * @return \Illuminate\Http\Response
     */
    public function edit(Alarma $alarma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlarmaRequest  $request
     * @param  \App\Models\Alarma  $alarma
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlarmaRequest $request, Alarma $alarma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alarma  $alarma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alarma $alarma)
    {
        //
    }
}
