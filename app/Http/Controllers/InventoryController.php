<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\ProductHistory;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\User;
use DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_detail = Product::with('inventory')->get();

        // echo "<pre>"; print_r($products_detail); die;
        return view('pages.inventory.stock_inventory', compact('products_detail'));
    }

    public function inventoryValidate(StoreInventoryRequest $request)
    {
        if ($request->ajax()) {
          $data = $request->all();
          if ($data['check1_product_id']) {
            Inventory::where('product_id', $data['check1_product_id'])->update(['check_stock_physic_1' =>1]);
          }else {
            Inventory::where('product_id', $data['check2_product_id'])->update(['check_stock_physic_2' =>1]);
          }
        }

        if ($request->isMethod('POST')) {
          $result = $request->all();
          foreach ($result['product_id'] as $key => $value) {
            Inventory::where('product_id', $value)->update([
              "after_quantity" =>$result["stock_physic"][$key],
              "stock_physic" =>0,
              "check_stock_physic_1" =>0,
              "check_stock_physic_2" =>0
            ]);
          }

          return redirect()->back()->with('success', 'Le stock physique a été validé avec succès. Merci !');
        }

        $products_detail = Product::with('inventory')->get();
        $productDetail = Product::with('inventory')->firstOrFail();
        $inventoryCount = Inventory::count();
        $inventoryCheckCount = Inventory::where(['check_stock_physic_1' =>1, 'check_stock_physic_2' =>1])->count();

        // dd($inventoryCount, $inventoryCheckCount);

        return view('pages.inventory.inventory_validate', compact('products_detail', 'inventoryCount', 'inventoryCheckCount', 'productDetail'));
    }

    public function inventoryPhysicStockHs(StoreInventoryRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['product_id'] as $key => $value) {
                Inventory::where('product_id', $value)->update(['stock_hs_physic' => $data['hs_quantity'][$key]]);
            }

            $user_1 = User::where('email', 'comptabilite@fusiontechci.com')->firstOrFail();
            $user_2 = User::where('email', 'servicecommercial@fusiontechci.com')->firstOrFail();
            $users_detail = [$user_1, $user_2];

            foreach ($users_detail as $users) {
              $notification = new Notification;
              $inventories = Inventory::where('updated_at', now())->firstOrFail();
              $action_user = User::where('id', $inventories->author_id)->firstOrFail();
              $date = date_format($inventories->updated_at, 'd-m-Y');
              $heure = date_format($inventories->updated_at, 'H:i:s');

              $notification->title = "Inventaire";
              $notification->user_id = $users->id;
              $notification->description = "Vous êtes appelé à valider le stock hors service saisi par ".$action_user->name." le ".$date." à ".$heure;

              $notification->save();
            }

            return redirect()->back()->with('success', 'Le stock hors service a été enregistré avec succès. Merci !');
        }

        $stock_detail = Inventory::with('product')->get();
        $stock_detail_count = Inventory::with('product')->count();
        $stockDetail_count = Inventory::with('product')->where('stock_hs_physic', '<>', null)->count();

        return view('pages.inventory.physic_stock_hs', compact('stock_detail', 'stockDetail_count', 'stock_detail_count'));
    }

    public function inventoryStockValidate(StoreInventoryRequest $request)
    {
        if ($request->ajax()) {
          $data = $request->all();
          if ($data['check_1_product_id']) {
            Inventory::where('product_id', $data['check_1_product_id'])->update(['check_stock_hs_1' =>1]);
          }else {
            Inventory::where('product_id', $data['check_2_product_id'])->update(['check_stock_hs_2' =>1]);
          }
        }

        if ($request->isMethod('post')) {
          $result = $request->all();
          foreach ($result['product_id'] as $key => $value) {
            Inventory::where('product_id', $value)->update([
              "stock_hs" =>$result["stock_hs_physic"][$key],
              "stock_hs_physic" =>0,
              "check_stock_hs_1" =>0,
              "check_stock_hs_2" =>0
            ]);
          }

          return redirect()->back()->with('success', 'Le stock hors service a été validé avec succès. Merci !');
        }

        $stock_hs_detail = Inventory::with('product')->where('stock_hs_physic', '<>', 0)->get();
        $inventoryCount = Inventory::where('stock_hs_physic', '<>', 0)->count();
        $inventoryCheckCount = Inventory::where(['check_stock_hs_1' =>1, 'check_stock_hs_2' =>1])->count();

        return view('pages.inventory.stock_validate', compact('stock_hs_detail', 'inventoryCheckCount', 'inventoryCount'));
    }

    public function inventoryStockHs()
    {
        $stock_detail = Inventory::with('product')->where('stock_hs', '<>', null)->get();
        return view('pages.inventory.stock_hs', compact('stock_detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products_detail = Product::with('inventory')->get();
        $productDetail = Product::with('inventory')->firstOrFail();

        return view('pages.inventory.physic_stock', compact('products_detail', 'productDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInventoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInventoryRequest $request)
    {
        $data = $request->all();

        foreach ($data['product_id'] as $key => $value) {
          Inventory::where('product_id', $value)->update(['stock_physic' =>$data['physic_quantity'][$key]]);
        }

        $user_1 = User::where('email', 'comptabilite@fusiontechci.com')->firstOrFail();
        $user_2 = User::where('email', 'servicecommercial@fusiontechci.com')->firstOrFail();
        $users_detail = [$user_1, $user_2];

        foreach ($users_detail as $users) {
          $notification = new Notification;
          $inventories = Inventory::where('updated_at', now())->firstOrFail();
          $action_user = User::where('id', $inventories->author_id)->firstOrFail();
          $date = date_format($inventories->updated_at, 'd-m-Y');
          $heure = date_format($inventories->updated_at, 'H:i:s');

          $notification->title = "Inventaire";
          $notification->user_id = $users->id;
          $notification->description = "Vous êtes appelé à valider le stock physique saisi par ".$action_user->name." le ".$date." à ".$heure;

          $notification->save();
        }

        return redirect()->back()->with('success', 'Le stock physique a été enregistré avec succès. Merci !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
