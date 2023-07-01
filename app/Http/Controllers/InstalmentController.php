<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstalmentRequest;
use App\Http\Requests\UpdateInstalmentRequest;
use App\Models\Instalment;
use App\Models\User;
use Auth;

class InstalmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instalments = Instalment::orderBy('id', 'DESC')->paginate(10);
        $users = User::get();

        return view('pages.instalment.index', compact('instalments', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.instalment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstalmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstalmentRequest $request)
    {
        $data = $request->all();
        // dd($data);

        $instalment = new Instalment;

        $instalment->type = $data['instalment_type'];
        $instalment->number = $data['instalment_number'];
        $instalment->amount = $data['instalment_amount'];
        $instalment->date = $data['instalment_date'];
        $instalment->author_id = Auth::id();

        $instalment->save();

        return to_route('instalments.index')->with('success', 'Votre Versement a été enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instalment  $instalment
     * @return \Illuminate\Http\Response
     */
    public function show(Instalment $instalment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instalment  $instalment
     * @return \Illuminate\Http\Response
     */
    public function edit(Instalment $instalment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstalmentRequest  $request
     * @param  \App\Models\Instalment  $instalment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstalmentRequest $request, Instalment $instalment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instalment  $instalment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instalment $instalment)
    {
        //
    }
}
