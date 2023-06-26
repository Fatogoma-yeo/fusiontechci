<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Gender;
use App\Models\Orders;
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
                $output.=   '<li class="cursor-pointer p-2 border-b text-primary flex justify-between items-center">'.
                                    '<p class="w-full flex justify-between" id="getCustomerSelect">'.
                                      '<span class="" id="customer_name">'.$client->name.'</span>'.
                                      '<span class="">'.$this->currency($client->purchases_amount).'</span>'.
                                    '</p>'.
                                    '<p class="flex items-center">'.
                                      '<button @click="openCustomerHistory('.$client->id.')" class="mx-2 rounded-full h-8 w-8 flex items-center justify-center border hover:bg-blue-700 hover:text-white">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                          </svg>
                                      </button>'.
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

            $clients = Client::where('created_at', Carbon::now())->latest()->firstOrFail();

            return response()->json(["customer" => $clients]);
        }
    }

    public function proceedCustomer(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $order_customer = Orders::where(['id' => $data['orders_id'], 'author' => Auth::id()])->firstOrFail();
            $customer_detail = Client::where('id', $order_customer->customer_id)->firstOrFail();
            $customer_name = $customer_detail->name;

            return Response($customer_name);
        }
    }

    public function CustomerAccountHistory(Request $request)
    {
        if ($request->ajax()) {
              $data = $request->all();

              $output = '';
              $customer_order_histories = Orders::where(['customer_id' => $data['customer_id'], 'author' =>Auth::id()])->get();
              $customer_order_count = Orders::where(['customer_id' => $data['customer_id'], 'author' =>Auth::id()])->count();
              $customer = Client::where('id', $data['customer_id'])->firstOrFail();

              if ($customer_order_count > 0) {
                  $summary = __('Summary For'); $total_purchases = __('Total Purchases'); $total_owed = __('Total Owed'); $last_purchase = __('Last Purchases'); $order = __('Order'); $option = __('Options'); $code = __('Code');
                  $delivery = __('Delivery'); $status = __('Status'); $total = __('Total'); $attente = __('On Hold'); $payer = __('Set Paid'); $partiellement = __('Partially Paid');

                    $output  .=  '<div class="flex flex-col flex-auto">
                                      <div class="flex-auto p-2 flex flex-col">
                                          <div class="-mx-4 flex flex-wrap">
                                              <div class="px-4 mb-4 w-full">
                                                  <h2 class="font-semibold">'.$summary.' : '.$customer->name.'</h2>
                                              </div>
                                              <div class="px-4 mb-4 md:w-1/2">
                                                  <div class="rounded-lg shadow bg-transparent bg-gradient-to-br from-green-400 to-green-600 p-2 flex flex-col text-white">
                                                      <h3 class="font-medium text-lg">'.$total_purchases.'</h3>
                                                      <div class="w-full flex justify-end">
                                                          <h2 class="font-bold">'.$this->currency($customer->purchases_amount).'</h2>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="px-4 mb-4 md:w-1/2">
                                                  <div class="rounded-lg shadow bg-transparent bg-gradient-to-br from-red-300 via-red-400 to-red-500 p-2 text-white">
                                                      <h3 class="font-medium text-lg">'.$total_owed.'</h3>
                                                      <div class="w-full flex justify-end">
                                                          <h2 class="text-xl font-bold">'.$this->currency($customer->owed_amount).'</h2>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="flex flex-auto flex-col overflow-hidden">
                                        <div class="py-2 w-full">
                                            <h2 class="font-semibold text-primary">'.$last_purchase.'</h2>
                                        </div>
                                        <div class="flex-auto flex-col flex overflow-hidden">
                                            <div class="flex-auto overflow-y-auto">
                                                <table class="table w-full">
                                                    <thead>
                                                        <tr class="text-primary bg-gray-300">
                                                            <th colspan="3" width="150" class="p-2 border border-gray-800 font-semibold">'.$order.'</th>
                                                            <th width="50" class="p-2 border border-gray-800 font-semibold">'.$option.'</th>
                                                        </tr>
                                                    </thead>';

                  foreach ($customer_order_histories as $key => $orders) {
                         $output .='                <tbody class="text-primary">
                                                        <tr>
                                                            <td colspan="3" class="p-2 text-center border border-gray-800">
                                                                <div class="flex flex-col items-start">
                                                                    <h3 class="font-bold">'.$code.': '.$orders->code.'</h3>
                                                                    <div class="md:-mx-2 w-full flex flex-row md:flex-row">
                                                                        <div class="md:px-2 flex items-start md:w-1/2">
                                                                            <small>'.$total.': '.$this->currency($orders->total).'</small>
                                                                        </div>
                                                                        <div class="md:px-2 flex items-start md:w-1/2">
                                                                            <small>'.$status.': ';
                                                                              switch ($orders->payment_status) {
                                                                                case 'hold':
                                                                            $output .= $attente;
                                                                                  break;

                                                                                case 'paid':
                                                                            $output .= $payer;
                                                                                  break;

                                                                                case 'partially_paid':
                                                                            $output .= $partiellement;
                                                                                  break;
                                                                              }
                                                                $output .= '</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="p-2 text-center border border-gray-800">
                                                                <button @click="openOrderOptions()" class="rounded-full h-8 px-2 flex items-center justify-center border border-gray hover:bg-green-600 hover:text-white">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                                                                    </svg>
                                                                    <span class="ml-1">'.$option.'</span>
                                                                </button>
                                                            </td>
                                                        </tr>';
                    }

                  $output .='                         </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>';


                    return Response($output);

              }else {
                  $nothing = __('No orders...');

                  $output .= '<div class="h-full v-full items-center justify-center flex">
                                  <h3 class="text-semibold flex justify-center">'.$nothing.'</h3>
                              </div>';

                  return Response($output);
              }
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
