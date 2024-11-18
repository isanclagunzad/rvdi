<?php

namespace App\Http\Controllers;

use App\Http\Requests\CutoffRequest;
use App\Model\CutOff;

class CutOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('manage-employee');

        return response()->json(CutOff::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CutoffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CutoffRequest $request)
    {
        $this->authorize('manage-employee');

        CutOff::create($request->all());

        return response()->json(['message' => 'Cuttoff added succesfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CutOff  $cutOff
     * @return \Illuminate\Http\Response
     */
    public function show(CutOff $cutOff)
    {
        $this->authorize('manage-employee');

        return response()->json($cutOff);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CutoffRequest  $request
     * @param  \App\CutOff  $cutOff
     * @return \Illuminate\Http\Response
     */
    public function update(CutoffRequest $request, CutOff $cutOff)
    {
        $this->authorize('manage-employee');
        
        foreach($cutOff->getAttributes() as $attribute => $value) {
            if(! $request->input($attribute)) {
                continue;
            }

            $cutOff->$attribute = $request->input($attribute);
        }

        $cutOff->save();

        return response()->json(['message' => 'Cutoff update successful.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CutOff  $cutOff
     * @return \Illuminate\Http\Response
     */
    public function destroy(CutOff $cutOff)
    {
        $this->authorize('manage-employee');

        $cutOff->delete();

        return response()->json(['message' => 'Cutoff successfully deleted.']);
    }
}
