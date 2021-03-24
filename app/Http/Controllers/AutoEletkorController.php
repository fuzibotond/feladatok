<?php

namespace App\Http\Controllers;

use App\Models\Auto_eletkor;
use Illuminate\Http\Request;

class AutoEletkorController extends Controller
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
        return view('auto_eletkor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'megnevezes' => 'required'
        ]);

        $auto_eletkor = new Auto_eletkor([
            'megnevezes' => $request->get('megnevezes')
        ]);
        $auto_eletkor->save();
        return redirect()->route('auto_eletkors.create')->with('success', 'Data Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auto_eletkor  $auto_eletkor
     * @return \Illuminate\Http\Response
     */
    public function show(Auto_eletkor $auto_eletkor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auto_eletkor  $auto_eletkor
     * @return \Illuminate\Http\Response
     */
    public function edit(Auto_eletkor $auto_eletkor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auto_eletkor  $auto_eletkor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auto_eletkor $auto_eletkor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auto_eletkor  $auto_eletkor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auto_eletkor $auto_eletkor)
    {
        //
    }
}
