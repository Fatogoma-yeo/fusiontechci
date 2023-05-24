<?php

namespace App\Http\Controllers\Dashboard;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Store\StoreProviderRequest;
use App\Http\Requests\Dashboard\Update\UpdateProviderRequest;
use App\Http\Requests\Dashboard\ProviderRequest;
use App\Services\ProviderService;
use App\Models\Provider;

class ProviderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct(
         ProviderService $providerService,)
     {
         $this->middleware('permission:providers_access|providers_list|providers_create|providers_edit|providers_show|providers_delete', ['only' => ['index','store']]);
         $this->middleware('permission:providers_create', ['only' =>['create','store']]);
         $this->middleware('permission:providers_edit', ['only' =>['edit','update']]);
         $this->middleware('permission:providers_delete', ['only' =>['destroy']]);
         $this->providerService = $providerService;
     }

    public function index()
    {
        $providers = Provider::orderBy('id', 'DESC')->paginate(5);
        return view('pages.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProviderRequest $request)
    {
        $data = $request->only([
            'name', 'first_name', 'phone', 'email', 'address',
        ]);

        return $this->providerService->create( $data );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        return view('pages.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProviderRequest $request,Provider $provider)
    {
        $data = $request->only([
            'name', 'first_name', 'phone', 'email', 'address',
        ]);

        return $this->providerService->update($provider->id, $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();

        return redirect()->back();
    }
}
