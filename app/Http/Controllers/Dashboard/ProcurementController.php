<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Store\StoreProcurementRequest;
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
        $providers = Provider::with('procurement')->get();
        foreach ($providers as $provider) {
            $providers = $provider;
        }
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

        $procurementDetail = Procurement::where('created_at', now())->first();
        $expenseCategories = ExpenseCategory::where('account', '002')->first();

        $cash_flows->name = $data['name'];
        $cash_flows->procurement_id = $procurementDetail->id;
        $cash_flows->expense_category_id = $expenseCategories->id;
        $cash_flows->value = $data['cost'];
        $cash_flows->operation = 'debit';
        $cash_flows->author_id = Auth::id();

        $cash_flows->save();

        foreach ($data['product_id'] as $key => $value) {
            // procurement product
            $procurementDetail = Procurement::where('created_at', Carbon::now())->get();
            foreach ($procurementDetail as $procurement_detail) {
                $procurement_id = $procurement_detail->id;
                $procurement_name = $procurement_detail->name;
            }

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
            $procurementProduct->procurement_id = $procurement_id;
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
                    $productHistories->procurement_id = $procurement_id;
                    $productHistories->procurement_name = $procurement_name;
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
                    $procurementProductDetails = ProcurementsProduct::where('product_id', $value)->latest()->first();
                    $ProductHistoryDetails = ProductHistory::where('product_id', $value)->latest()->first();
                    $productHistories->product_name = $product_name;
                    $productHistories->purchase_price = $data['purchase_price'][$key];
                    $productHistories->procurement_id = $procurement_id;
                    $productHistories->procurement_name = $procurement_name;
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
                    $inventoryDetails = Inventory::where('product_id', $value)->latest()->first();
                    $inventory_quantity = $inventoryDetails->before_quantity + $data['quantity'][$key];

                    Inventory::where('product_id', $value)->update(['before_quantity' =>$inventory_quantity]);
                    break;
            }

            // echo '<pre>';print_r($procurement);die;
        }

        $provider_purchases = Procurement::select(
            DB::raw('name as name'),
            DB::raw('payment_status as payment_status'),
            DB::raw('provider_id as provider_id'),
            DB::raw('cost as total'),
        )
        ->groupBy('payment_status')
        ->groupBy('provider_id')
        ->groupBy('name')
        ->groupBy('total')
        ->get();

        // echo '<pre>';print_r($provider_purchases);die;
        foreach ($provider_purchases as $provider_purchase) {
            $purchaseDetails = $provider_purchase;
        }

        $provider = Provider::where('id', $purchaseDetails->provider_id)->first();
        if ($purchaseDetails->payment_status == 'paid') {
            $provider->update(['amount_paid' => $purchaseDetails->total]);
        }else {
            $provider->update(['amount_du' => $purchaseDetails->total]);
        }

        return redirect()->back()->with('success', 'La Commande a été enregistrer avec succès');
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
        //
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
