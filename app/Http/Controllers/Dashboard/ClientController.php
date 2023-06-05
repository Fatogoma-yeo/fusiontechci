<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Gender;
use App\Services\ClientService;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Store\StoreClientRequest;
use App\Http\Requests\Dashboard\Update\UpdateClientRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClientController extends Controller
{

    public function currency($amount)
    {
        return 'F CFA ' .number_format($amount);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct(
         ClientService $clientService,)
    {
        $this->middleware('permission:clients_access|clients_list|clients_create|clients_edit|clients_show|clients_delete', ['only' => ['index','store']]);
        $this->middleware('permission:clients_create', ['only' =>['create','store']]);
        $this->middleware('permission:clients_edit', ['only' =>['edit','update']]);
        $this->middleware('permission:clients_delete', ['only' =>['destroy']]);
        $this->clientService = $clientService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::get();
            $output="";
            foreach ($clients as $key => $client) {
                $output.=   '<li class="cursor-pointer p-2 border-b text-primary flex justify-between items-center" id="getCustomerSelect">'.
                                    '<span id="customer_name">'.$client->name.'</span>'.
                                    '<p class="flex items-center">'.
                                        '<span class="purchase-amount">'.$this->currency($client->purchases_amount).'</span>'.
                                    '</p>'.
                            '</li>';
            }

            $notput ='  <li class="flex-auto w-full flex items-center justify-center flex-col p-4">'.
                            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">'.
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />'.
                            '</svg>'.
                            "Aucun client n'a été enregistré".
                        '</li>'.
                        '<li @click=" openTab = 1 " class="p-2 cursor-pointer text-center text-primary">'.
                            '<span class="border-b border-dashed border-green-600">'.
                                "Créer un client".
                            '</span>'.
                        '</li>';

            $notpuTtoNew ='  <li class="flex-auto w-full flex items-center justify-center flex-col p-4">'.
                            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">'.
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />'.
                            '</svg>'.
                            "Aucun client n'a été enregistré".
                        '</li>'.
                        '<li @click="newusermodal()" class="p-2 cursor-pointer text-center text-primary">'.
                            '<span class="border-b border-dashed border-green-600">'.
                                "Créer un client".
                            '</span>'.
                        '</li>';

            return response()->json(["customers" => $output, "nothing" => $notput, "newuser" => $notpuTtoNew]);
        }

        $userDetails = User::get();
        $clients = Client::orderBy('id', 'DESC')->paginate(5);

        return view('pages.clients.index', compact('clients', 'userDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genders = Gender::get();

        return view('pages.clients.create', compact('genders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $data = $request->only([
            'name', 'first_name', 'phone', 'email', 'gender'
        ]);

        return $this->clientService->create( $data );
    }

    public function posCustomer(StoreClientRequest $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $customers = new Client;

            $customers->name = $data['name'];
            $customers->email = $data['email'];
            $customers->first_name = $data['first_name'];
            $customers->phone = $data['phone'];
            $customers->gender = $data['gender'];
            $customers->author_id = Auth::id();

            $customers->save();

            $clients = Client::where('created_at', Carbon::now())->latest()->first();

            return response()->json(["customer" => $clients]);
        }
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
    * @param  App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $genders = Gender::get();
        return view('pages.clients.edit', compact('client', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request,Client $client)
    {
        $data = $request->only([
            'name', 'first_name', 'phone', 'email', 'gender',
        ]);

        return $this->clientService->update($client->id, $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->back();
    }
}
