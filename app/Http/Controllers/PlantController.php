<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Plant;

class PlantController extends Controller
{
    public function showAll() {
        $plants =  json_encode(Plant::all()->jsonSerialize());
        return view('index')->with('plants', $plants);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Plant::all()->jsonSerialize(), Response::HTTP_OK);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plant = new Plant;
        $plant->name = $request->name;
        $plant->water = $request->water;
        $plant->water_interval = $request->water_interval;
        $plant->water_next = date('2018-05-20 21:35:58');
        $plant->save();

        return response($plant->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plant = Plant::findOrFail($id);
        $plant->name = $request->name;
        $plant->water = $request->water;
        $plant->water_interval = $request->water_interval;
        $plant->water_next = $request->water_next;
        $plant->save();
      
        return response($plant->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Plant::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
