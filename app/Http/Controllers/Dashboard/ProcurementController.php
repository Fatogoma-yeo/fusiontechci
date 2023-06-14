<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Store\StoreProcurementRequest;
use App\Http\Requests\Dashboard\Update\UpdateProcurementRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CashFlow;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\Provider;
use App\Models\Procurement;
use App\Models\ProcurementsProduct;
use App\Models\ExpenseCategory;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\User;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
         $this->middleware('permission:procurement_access|procurement_list|procurement_create|procurement_edit|procurement_show|procurement_delete', ['only' => ['index','store']]);
         $this->middleware('permission:procurement_create', ['only' =>['create','store']]);
         $this->middleware('permission:procurement_edit', ['only' =>['edit','update']]);
         $this->middleware('permission:procurement_delete', ['only' =>['destroy']]);
     }

    public function index()
    {
        $userDetails = User::get();
        $procurements = Procurement::paginate(5);
        $providers = Provider::get();
        // dd($providers);

        return view('pages.procurements.index', compact('procurements', 'providers', 'userDetails'));
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {

            $output="";
            $products=Product::where('name','LIKE','%'.$request->search."%")->get();

            if ($products) {
                $output = '<ul class="block py-2">';
                    foreach ($products as $key => $product) {
                        $output.= '<li class="border list bg-gray-100 py-2 cursor-pointer shadow-md border-gray-400"><span class="ml-4 text-lg"><input type="text" name="product_id" id="product_id" class="hidden" value='.$product->id.'>'.$product->name.'</span></li>';
                    }
                $output .= '</ul>';

                return Response($output);
            }
        }
    }

    public function procured(Request $request)
    {
        if ($request->ajax()) {
            $procurementDet = Procurement::where('id', $request["procurement_id"])->firstOrFail();
            $providers = Provider::where('id', $procurementDet->provider_id)->firstOrFail();

            $providers->update(['amount_paid' => $providers->amount_paid + $procurementDet->cost]);
            $providers->update(['amount_du' => $providers->amount_du - $procurementDet->cost]);

            $procurementDet->update(['payment_status' => 'paid']);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = Provider::get();

        return view('pages.procurements.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProcurementRequest $request)
    {
        $data = $request->all();
        // echo '<pre>';print_r($data); die;

        $procurement = new Procurement;
        $cash_flows = new CashFlow;

        $procurement->name = $data['name'];

        if ($data['provider_id'] == null) {
            $procurement->provider_id = 0;
        }else {
            $procurement->provider_id = $data['provider_id'];
        }
        if ($data['invoice_number'] == null) {
            $procurement->invoice_number = 'N/A';
        }else {
            $procurement->invoice_number = $data['invoice_number'];
        }
        if ($data['invoice_date'] == null) {
            $procurement->invoice_date = now();
        }else {
            $procurement->invoice_date = $data['invoice_date'];
        }
        if ($data['status_payment'] == null) {
            $procurement->payment_status = "unpaid";
        }else {
            $procurement->payment_status = $data['status_payment'];
        }

        $procurement->value = $data['value'];
        $procurement->cost = $data['cost'];
        $procurement->author_id = Auth::id();

        $procurement->save();

        $procurementDetail = Procurement::where('author_id', Auth::id())->latest()->firstOrFail();
        $expenseCategories = ExpenseCategory::where('account', '002')->firstOrFail();

        $cash_flows->name = $data['name'];
        $cash_flows->procurement_id = $procurementDetail->id;
        $cash_flows->expense_category_id = $expenseCategories->id;
        $cash_flows->value = $data['cost'];
        $cash_flows->operation = 'debit';
        $cash_flows->author_id = Auth::id();

        $cash_flows->save();

        foreach ($data['product_id'] as $key => $value) {
            // procurement product
            $procurementProduct = new ProcurementsProduct;
            $productHistories = new ProductHistory;
            $inventories = new Inventory;

            $product_detail = Product::where('id', $value)->get();
            foreach ($product_detail as $product) {
                $product_name = $product->name;
            }
            $procurementProduct->product_name = $product_name;
            $procurementProduct->gross_purchase_price = $data['gross_purchase_price'][$key];
            $procurementProduct->net_purchase_price = $data['net_purchase_price'][$key];
            $procurementProduct->procurement_id = $procurementDetail->id;
            $procurementProduct->product_id = $value;
            $procurementProduct->quantity = $data['quantity'][$key];
            $procurementProduct->purchase_price = $data['purchase_price'][$key];
            $procurementProduct->author_id = Auth::id();

            $procurementProduct->save();

            // Product History
            $proHistoryCount = ProductHistory::where('product_id', $value)->count();
            $inventoryCount = Inventory::where('product_id', $value)->count();

            switch ($proHistoryCount) {
                case 0:
                    $productHistories->product_name = $product_name;
                    $productHistories->purchase_price = $data['purchase_price'][$key];
                    $productHistories->procurement_id = $procurementDetail->id;
                    $productHistories->procurement_name = $procurementDetail->name;
                    $productHistories->product_id = $value;
                    $productHistories->operation = __('Stocked');
                    $productHistories->before_quantity = 0;
                    $productHistories->quantity = $data['quantity'][$key];
                    $productHistories->after_quantity = $data['quantity'][$key];
                    $productHistories->unit_price = $data['net_purchase_price'][$key];
                    $productHistories->total_price = $data['quantity'][$key] * $data['net_purchase_price'][$key];
                    $productHistories->author_id = Auth::id();

                    $productHistories->save();
                    break;

                default:
                    $procurementProductDetails = ProcurementsProduct::where('product_id', $value)->latest()->firstOrFail();
                    $ProductHistoryDetails = ProductHistory::where('product_id', $value)->latest()->firstOrFail();
                    $productHistories->product_name = $product_name;
                    $productHistories->purchase_price = $data['purchase_price'][$key];
                    $productHistories->procurement_id = $procurementDetail->id;
                    $productHistories->procurement_name = $procurementDetail->name;
                    $productHistories->product_id = $value;
                    $productHistories->operation = __('Stocked');
                    $productHistories->before_quantity = $ProductHistoryDetails->after_quantity;
                    $productHistories->quantity = $data['quantity'][$key];
                    $productHistories->after_quantity = $ProductHistoryDetails->after_quantity + $data['quantity'][$key];
                    $productHistories->unit_price = $data['net_purchase_price'][$key];
                    $productHistories->total_price = $data['quantity'][$key] * $ProductHistoryDetails->unit_price;

                    $productHistories->author_id = Auth::id();

                    $productHistories->save();
                    break;
            }

            switch ($inventoryCount) {
                case 0:
                    $inventories->product_id = $value;
                    $inventories->before_quantity = $data['quantity'][$key];
                    $inventories->after_quantity = $data['quantity'][$key];
                    $inventories->purchase_price = $data['purchase_price'][$key];
                    $inventories->unit_price = $data['net_purchase_price'][$key];
                    $inventories->author_id = Auth::id();

                    $inventories->save();
                    break;

                default:
                    $inventoryDetails = Inventory::where('product_id', $value)->latest()->firstOrFail();
                    $inventory_quantity = $inventoryDetails->before_quantity + $data['quantity'][$key];

                    Inventory::where('product_id', $value)->update(['before_quantity' =>$inventory_quantity]);
                    break;
            }

            // echo '<pre>';print_r($procurement);die;
        }

        $provider = Provider::where('id', $procurementDetail->provider_id)->firstOrFail();
        if ($procurementDetail->payment_status == 'paid') {
            $provider->update(['amount_paid' => $procurementDetail->cost]);
        }else {
            $provider->update(['amount_du' => $procurementDetail->cost]);
        }

        $notification = new Notification;
        $action_user = User::where('id', $procurementDetail->author_id)->firstOrFail();
        $users = User::where('email', 'comptabilite@fusiontechci.com')->firstOrFail();

        $notification->title = "Achats";
        $notification->user_id = $users->id;
        $notification->description = "Nouvel achat effectué par ".$action_user->name." chez ".$provider->name." portant la référence ".$procurementDetail->name;

        $notification->save();

        return redirect()->back()->with('success', 'La Commande a été enregistrer avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Procurement $procurement)
    {
        return view('pages.procurements.show', compact('procurement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Procurement $procurement)
    {
        $providers = Provider::get();

        return view('pages.procurements.edit', compact('providers', 'procurement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProcurementRequest $request, Procurement $procurement)
    {

         if ($request["provider_id"] != $procurement->provider_id) {
              $provider_detail = Provider::where('id', $request["provider_id"])->firstOrFail();
              $providers_details = Provider::where('id', $procurement->provider_id)->firstOrFail();
              $object = "le changement du fournisseur ".$providers_details->name." par ".$provider_detail->name;

              if ($request["status_payment"] == 'paid') {
                  switch ($provider_detail->amount_paid) {
                    case 0:
                      $provider_detail->update(['amount_paid' => $procurement->cost]);
                      break;

                    default:
                      $provider_detail->update(['amount_paid' => $provider_detail->amount_paid + $procurement->cost]);
                      break;
                  }
                  switch ($providers_details->amount_paid) {
                    case 0:
                      $providers_details->update(['amount_paid' => 0]);
                      break;

                    default:
                      $providers_details->update(['amount_paid' => $providers_details->amount_paid - $procurement->cost]);
                      break;
                  }
                }else {
                  switch ($provider_detail->amount_du) {
                    case 0:
                      $provider_detail->update(['amount_du' => $procurement->cost]);
                      break;

                    default:
                      $provider_detail->update(['amount_du' => $provider_detail->amount_du + $procurement->cost]);
                      break;
                  }
                  switch ($providers_details->amount_du) {
                      case 0:
                        $providers_details->update(['amount_du' => 0]);
                        break;

                      default:
                        $providers_details->update(['amount_du' => $providers_details->amount_du - $procurement->cost]);
                        break;
                   }
                }
          }

          if ($request["provider_id"] == $procurement->provider_id) {
              if ($request["status_payment"] != $procurement->payment_status) {
                  $object = "le changement de status de paiement";
                  $providers = Provider::where('id', $procurement->provider_id)->firstOrFail();
                  if ($procurement->payment_status == 'paid') {
                    switch ($providers->amount_du) {
                      case 0:
                        $providers->update(['amount_du' => $procurement->cost]);
                        $providers->update(['amount_paid' => $providers->amount_paid - $procurement->cost]);
                        break;

                      default:
                        $providers->update(['amount_du' => $providers->amount_du + $procurement->cost]);
                        $providers->update(['amount_paid' => $providers->amount_paid - $procurement->cost]);
                        break;
                    }

                  }else {
                    switch ($providers->amount_paid) {
                      case 0:
                        $providers->update(['amount_paid' => $procurement->cost]);
                        $providers->update(['amount_du' => $providers->amount_du - $procurement->cost]);
                        break;

                      default:
                        $providers->update(['amount_paid' => $providers->amount_paid + $procurement->cost]);
                        $providers->update(['amount_du' => $providers->amount_du - $procurement->cost]);
                        break;
                    }

                  }
              }
          }

          $procurements = Procurement::find($procurement->id);
          $fields = $request->only(['name', 'invoice_number', 'provider_id']);

          foreach ($fields as $name => $field) {
            $procurements->$name = $field;
          }

          $procurements->payment_status = $request["status_payment"];
          $procurements->value =$procurement->value;
          $procurements->cost = $procurement->cost;
          $procurements->author_id = Auth::id();

          $procurements->update();

          $notification = new Notification;
          $action_user_id = Procurement::where('updated_at', now())->firstOrFail();
          $action_user = User::where('id', $action_user_id->author_id)->firstOrFail();
          $users = User::where('email', 'comptabilite@fusiontechci.com')->firstOrFail();

          $notification->title = "Modification";
          $notification->user_id = $users->id;
          $notification->description = "Nouvelle modification faite par ".$action_user->name." sur ".$object." de la commande ".$procurement->name;

          $notification->save();

        return redirect()->route('procurements.index')->with('success', 'L\'achat a été modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
