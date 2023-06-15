<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcurementsProduct;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\ProductCategory;
use App\Models\ExpenseCategory;
use App\Models\PosList;
use App\Models\Client;
use App\Models\CashFlow;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\Inventory;
use App\Models\User;
use Auth;
use DB;

class OrdersController extends Controller
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

     function __construct()
     {
         $this->middleware('permission:orders_access|orders_create|orders_edit|orders_show|orders_delete', ['only' => ['index','store']]);
         $this->middleware('permission:orders_create', ['only' =>['create','store']]);
         $this->middleware('permission:orders_edit', ['only' =>['edit','update']]);
         $this->middleware('permission:orders_delete', ['only' =>['destroy']]);
     }

    public function index(Request $request)
    {
        $productsDetails = "";
        if ($request->ajax()) {
            $data = $request->all();
            $product_id = $data['product_id'];
            $procurements = ProcurementsProduct::where('product_id', $product_id)->get();
            $countprocurement = ProcurementsProduct::where('product_id', $product_id)->count();
            foreach ($procurements as $procurement) {
                $procurementDetail = $procurement;
            }
            $products = Product::where('id', $product_id)->get();
            foreach ($products as $product) {
                $productDetail = $product;
            }
            $countposlist = PosList::where(['product_id' => $product_id, 'author_id' => Auth::user()->id])->count();
            $Poslists = PosList::where(['product_id' => $product_id, 'author_id' => Auth::user()->id])->get();
            $History_product = ProductHistory::where('product_id', $product_id)->latest()->firstOrFail();
            if ($countprocurement > 0) {
                if ($History_product->after_quantity >= $data['quantity']) {
                    if ($countposlist === 0) {
                        $poslist = new PosList;
                        $poslist->product_id = $product_id;
                        $poslist->product_name = $productDetail->name;
                        $poslist->net_purchase_price = $procurementDetail->net_purchase_price;
                        $poslist->gross_purchase_price = $procurementDetail->gross_purchase_price;
                        $poslist->quantity = $data['quantity'];
                        $poslist->author_id = $data['author_id'];
                        $poslist->save();

                        $productsDetails = PosList::where('author_id', Auth::id())->get();
                        $productsDetails = json_decode($productsDetails, true);
                        return view('pages.orders.products', compact('productsDetails'));

                    }elseif ($Poslists) {
                        return response()->json(['action' => 'is_procurement', 'message' => 'Vous avez déjà choisis ce produit merci de choisir un autre.', ]);
                    }
                }else {
                    return response()->json(['action' => 'low_quantity', 'message' => 'La quantité restante de ce produit ne peut pas supporter cette commande. Reste '.$History_product->after_quantity.' !']);
                }
            }else {
                $notify = ['action' => 'isnt_procurement', 'message' => 'Impossible d\'ajouter le produit, il n\'y a pas assez de stock. Restant 0'];
                return response()->json($notify);
            }

        }else {
            PosList::where('author_id', Auth::user()->id)->delete();
        }

        $product_detail = Product::first();

        return view('pages.orders.index', compact('productsDetails', 'product_detail'));
    }

    public function search(Request $request)
    {
      if ($request->ajax()) {

            $output = '';
            $products_Detail = Product::with('procurement')->where('name','LIKE','%'.$request->pos_search."%")->get();

            if ($request->pos_search != '') {

                foreach ($products_Detail as $products) {
                    if (count($products->procurement) > 0) {
                        foreach ($products->procurement->unique(fn ($p) => $p->gross_purchase_price) as $product) {
                                $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                                x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                                <a href="#">
                                                    <input type="text" class="hidden" name="product_id" id="product_id" value='.$product->product_id.'  >';

                                if($products->media){
                                    $output .= '<img src='.$products->media.' class="h-full object-cover" alt="Image Produits" />';
                                }else {
                                    $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>';
                                }

                                $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                                <span class="flex justify-center">
                                                    <h2 class="text-sm font-bold">'.$product->product_name.'</h2>
                                                </span>
                                                <span class="flex justify-center">
                                                    <h3 class="text-sm font-bold">'.
                                                      $this->currency($product->net_purchase_price ).'
                                                    </h3>
                                                  </span>
                                              </div>
                                          </a>
                                      </div>';
                        }
                    }else {
                        $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                        x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                        <a href="#">
                                            <input type="text" class="hidden" name="product_id" id="product_id" value='.$products->id.'  >';

                        if($products->media){
                            $output .= '<img src='.$products->media.' class="h-full object-cover" alt="Image Produits" />';
                        }else {
                            $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>';
                        }

                        $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                        <span class="flex justify-center">
                                            <h2 class="text-sm font-bold">'.$products->name.'</h2>
                                        </span>
                                    </div>
                                </a>
                            </div>';

                    }
                }

                return Response($output);

            }else {

                $output = '';
                $products_Detail = Product::with('procurement')->get();

                foreach ($products_Detail as $products) {
                    if (count($products->procurement) > 0) {
                        foreach ($products->procurement->unique(fn ($p) => $p->gross_purchase_price) as $product) {
                                $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                                x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                                <a href="#">
                                                    <input type="text" class="hidden" name="product_id" id="product_id" value='.$product->product_id.'  >';

                                if($products->media){
                                    $output .= '<img src='.$products->media.' class="h-full object-cover" alt="Image Produits" />';
                                }else {
                                    $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>';
                                }

                                $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                                <span class="flex justify-center">
                                                    <h2 class="text-sm font-bold">'.$product->product_name.'</h2>
                                                </span>
                                                <span class="flex justify-center">
                                                    <h3 class="text-sm font-bold">'.
                                                      $this->currency($product->net_purchase_price ).'
                                                    </h3>
                                                  </span>
                                              </div>
                                          </a>
                                      </div>';
                        }
                    }else {
                        $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                        x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                        <a href="#">
                                            <input type="text" class="hidden" name="product_id" id="product_id" value='.$products->id.'  >';

                        if($products->media){
                            $output .= '<img src='.$products->media.' class="h-full object-cover" alt="Image Produits" />';
                        }else {
                            $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>';
                        }

                        $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                        <span class="flex justify-center">
                                            <h2 class="text-sm font-bold">'.$products->name.'</h2>
                                        </span>
                                    </div>
                                </a>
                            </div>';

                    }
                }

                return Response($output);
            }
       }
    }

    public function pendingSearch(Request $request)
    {
        if ($request->ajax()) {

             $output = '';
             $ordersDetail = Orders::with('customer')->where('change', '<>', 0)->where('author', Auth::id())->get();
             $ordersDetailCount = Orders::with('customer')->where('change', '<>', 0)->where('author', Auth::id())->count();
             $usersDetail = User::get();
             if ($ordersDetailCount > 0 ) {
                $cashier = __('Cashier'); $total = __('Total'); $customer = __('Customer'); $date = __('Date'); $open = __('Open'); $product = __('Products'); $print = __('Print');
                foreach ($ordersDetail as $key => $orders) {
                    $output .= '<div class="border-b w-full py-2">
                                    <div class="px-2">
                                        <div class="flex flex-wrap -mx-4">
                                            <div class="md:w-1/2 p-1">';
                                            foreach ($usersDetail as $user) {
                                                if ($user->id == $orders->author) {
                                                    $output .='<p class="text-sm py-1"><strong>'.$cashier.'</strong> : '.$user->name.'</p>';
                                                }
                                            }
                    $output .=                '<p class="text-sm py-1"><strong>'.$total.'</strong> : '.$this->currency($orders->total).'</p>
                                            </div>
                                            <div class="md:w-1/2 p-1">
                                                <p class="text-sm py-1"><strong>'.$customer.'</strong> : '.$orders->customer->name.'</p>
                                                <p class="text-sm py-1"><strong>'.$date.'</strong> : '.$orders->created_at.'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end w-full mt-2">
                                        <div class="flex rounded-lg overflow-hidden ns-buttons">
                                            <button onclick="proceedOpenOrder('.$orders->id.')" class="bg-blue-500 text-white outline-none px-2 py-1 text-sm">
                                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                              </svg>
                                               '.$open.'
                                            </button>
                                            <button @click="previewOrder('.$orders->id.')" class="bg-green-600 text-white outline-none px-2 py-1 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                '.$product.'
                                            </button>
                                            <button @click="printOrder('.$orders->id.')" class="bg-orange-600 text-white outline-none px-2 py-1 text-sm">
                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                               </svg>
                                               '.$print.'
                                            </button>
                                        </div>
                                    </div>
                                </div>';
                  }

                return Response($output);
             }else {
               $nothing = __('Nothing to display...');

               $output .= '<div class="h-full v-full items-center justify-center flex">
                               <h3 class="text-semibold flex justify-center">'.$nothing.'</h3>
                           </div>';

               return Response($output);
             }

        }
    }

    public function wishlist()
    {
        $product_counter = PosList::where('author_id', Auth::id())->count();
        echo json_encode($product_counter);
    }

    public function changeQuantity(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $History_product = ProductHistory::where('product_id', $data['product_id'])->latest()->firstOrFail();
            if ($History_product->after_quantity >= $data['quantity']) {
                PosList::where(['product_id' => $data['product_id'], 'author_id' => Auth::id()])->update(['quantity' => $data['quantity']]);

                $productsDetails = PosList::where('author_id', Auth::id())->get();
                $productsDetails = json_decode($productsDetails, true);
                return view('pages.orders.products', compact('productsDetails'));
            }else {
                return response()->json(['action' => 'low_quantity', 'message' => 'La quantité restante de ce produit ne peut pas supporter cette commande. Reste '.$History_product->after_quantity.' !']);
            }
        }
    }

    public function discount(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['product_id']) {
                $pos_products = PosList::where(['product_id' => $data['product_id'], 'author_id' => Auth::id()])->firstOrFail();
                $new_price = $pos_products->net_purchase_price - $data['discount'];
                if ($new_price < $pos_products->gross_purchase_price) {
                  return response()->json(['action' => "not_reduce", 'message' => "Cette réduction ne peut être appliquer. Veillez revoir votre somme de réduction"]);
                }else {

                  PosList::where(['product_id' => $data['product_id'], 'author_id' => Auth::id()])->update(['discount' => $data['discount'], "net_purchase_price" =>$new_price]);

                  $productsDetails = PosList::where('author_id', Auth::id())->get();
                  $productsDetails = json_decode($productsDetails, true);
                  return view('pages.orders.products', compact('productsDetails'));
                }
            }else {
                $disCout = PosList::where(['discount' => 0, 'author_id' => Auth::id()])->count();
                $poscount = PosList::where('author_id', Auth::id())->count();
                if ($disCout == $poscount) {
                    PosList::where('author_id', Auth::id())->update(['pos_discount' => $data['discount']]);
                    $pos_detail = PosList::where('author_id', Auth::id())->firstOrFail();
                    return response()->json(['posDiscount' => $pos_detail]);
                }else {
                    $productsDetails = PosList::where('author_id', Auth::id())->get();
                    $productsDetails = json_decode($productsDetails, true);
                    return view('pages.orders.products', compact('productsDetails'));
                }
            }
        }
    }

    public function pos_product(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $product_id = $data['product_id'];
            PosList::where(['product_id' => $product_id, 'author_id' => Auth::user()->id])->delete();

            $productsDetails = PosList::where('author_id', Auth::id())->get();
            $productsDetails = json_decode($productsDetails, true);
            return view('pages.orders.products', compact('productsDetails'));
        }
    }

    public function price(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $poslistcount = PosList::countposlist($data['product_id']);
            // echo "<pre>";print_r($poslistcount);die;
            if ($poslistcount == 1) {
                PosList::where(['product_id' => $data['product_id'], 'author_id' => Auth::id()])->update(['is_gross' => 1]);
                $productsDetails = PosList::where('author_id', Auth::id())->get();
                $productsDetails = json_decode($productsDetails, true);
                return view('pages.orders.products', compact('productsDetails'));
            }else {
                PosList::where(['product_id' => $data['product_id'], 'author_id' => Auth::id()])->update(['is_gross' => 0]);
                $productsDetails = PosList::where('author_id', Auth::id())->get();
                $productsDetails = json_decode($productsDetails, true);
                return view('pages.orders.products', compact('productsDetails'));
            }
        }
    }

    public function waiting(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $customersDetail = Client::where('name', 'LIKE', '%'.$data["customer"].'%')->firstOrFail();

            $date_generate = DATE_FORMAT(now(), 'dmy');

            $orders = new Orders;

            $orders->code = $date_generate.'-00'.rand(1,9);
            $orders->payment_status = "paid";
            $orders->discount = $data['discount'];
            $orders->subtotal = $data['subtotal'];
            $orders->total = $data['total'];
            $orders->tendered = 0;
            $orders->change = $orders->tendered - $data['total'];
            $orders->customer_id = $customersDetail->id;
            $orders->author = Auth::id();

            $orders->save();

            foreach ($data['product_id'] as $key => $value) {
                $ordersDetails = new OrderProduct;
                $Order = Orders::where(['created_at' => now(), 'author' => Auth::id()])->latest()->firstOrFail();
                $products = Product::with('category')->where('id', $value)->get();
                $procur_product = ProcurementsProduct::with('procurement')->where('product_id', $value)->get();

                foreach ($procur_product as $product_det) {
                    $purchase_price = $product_det->purchase_price;
                    $ordersDetails->procurement_product_id = $product_det->procurement_id;
                    $ordersDetails->purchase_price = $purchase_price;
                }
                foreach ($products as $product) {
                    $productCatId = $product->category->id;
                    $ordersDetails->product_category_id = $productCatId;
                }
                $ordersDetails->product_id = $value;
                $ordersDetails->orders_id = $Order->id;
                $ordersDetails->product_name = $data["product_name"][$key];
                $ordersDetails->quantity = $data["quantity"][$key];
                $ordersDetails->unit_price = $data["price"][$key];
                $ordersDetails->discount = $data["discount"];
                $ordersDetails->pos_subtotal = $data["pos_subtotal"][$key];
                $ordersDetails->author_id = Auth::id();

                $ordersDetails->save();

            }

        }
    }

    public function proceedOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $orders_detail = Orders::where(['id' => $data['orders_id'], 'author' => Auth::id()])->firstOrFail();
            $product_detail = OrderProduct::where(['orders_id' => $data['orders_id'], 'author_id' => Auth::id()])->get();
            $tendered = 0 - $orders_detail->change;

            foreach ($product_detail as $key => $order_product) {
                $products = ProcurementsProduct::where('product_id', $order_product->product_id)->firstOrFail();
                $poslist = new PosList;
                $poslist->product_id = $order_product->product_id;
                $poslist->product_name = $order_product->product_name;
                $poslist->pos_discount = $orders_detail->discount;
                $poslist->net_purchase_price = $order_product->unit_price;
                $poslist->gross_purchase_price = $products->gross_purchase_price;
                if ($poslist->net_purchase_price == $poslist->gross_purchase_price) {
                    $poslist->is_gross = 1;
                }else {
                    $poslist->is_gross = 0;
                }
                $poslist->quantity = $order_product->quantity;
                $poslist->author_id = $order_product->author_id;
                $poslist->save();
            }
            // Orders::where('id', $data['orders_id'])->update(['tendered' => $tendered, 'change' => 0]);

            $productsDetails = PosList::where('author_id', Auth::id())->get();
            $productsDetails = json_decode($productsDetails, true);
            return view('pages.orders.products', compact('productsDetails'));
        }
    }

    public function previewOrderProducts(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $output = '';
            $order_product_detail = OrderProduct::where('orders_id', $data['orders_id'])->get();
            $categoryLabel = __( 'Category' );

            foreach ($order_product_detail as $products) {
                $product_det = Product::with('category')->where('id', $products->product_id)->firstOrFail();
                $output .= '<div class="item">
                              <div class="flex-col border-b border-info-primary py-2">
                                  <div class="title font-semibold text-primary flex justify-between">
                                      <span>'.$products->product_name.' (x'.$products->quantity.')</span>
                                      <span>'.$this->currency($products->pos_subtotal).'</span>
                                  </div>
                                  <div class="text-sm text-primary">
                                      <ul>
                                          <li>'.$categoryLabel.' : '.$product_det->category->name.'</li>
                                      </ul>
                                  </div>
                              </div>
                          </div>';
            }

          return Response($output);
        }
    }

    public function cancelOrders(Request $request)
    {
       if ($request->ajax()) {
          $data = $request->all();

          $orders_products = OrderProduct::where(['orders_id' => $data['orders_id'], 'author_id' => Auth::id()])->get();

          foreach ($orders_products as $product) {
             OrderProduct::where(['product_id' => $product->product_id, 'author_id' => Auth::id()])->delete();
          }

          Orders::where(['id' => $data['orders_id'], 'author' => Auth::id()])->delete();
       }
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
        $data = $request->all();
        // echo "</pre>"; print_r($data); die;

        $customersDetail = Client::where('name', 'LIKE', '%'.$data["customer"].'%')->firstOrFail();

        $date_generate = DATE_FORMAT(now(), 'dmy');

        if ($data['orders_id'] != '') {

            Orders::where(['id' => $data['orders_id'], 'author' => Auth::id()])
            ->update([
              "discount" => $data["discount"],
              "subtotal" => $data["subtotal"],
              "tendered" => $data["total"],
              "change" => 0,
            ]);

        }else {
            $order = new Orders;

            $order->code = $date_generate.'-00'.rand(1,9);
            $order->payment_status = "paid";
            $order->discount = $data['discount'];
            $order->subtotal = $data['subtotal'];
            $order->tendered = $data['total'];
            $order->total = $data['total'];
            $order->customer_id = $customersDetail->id;
            $order->author = Auth::id();

            $order->save();

        }

        foreach ($data['product_id'] as $key => $value) {
            $product_id  = $data['product_id'][$key];
            $product_name = $data['product_name'][$key];
            $price = $data['price'][$key];
            $quantity = $data['quantity'][$key];
            $posSubtotal = $data['pos_subtotal'][$key];
            foreach (explode(',',$product_id) as $value) {
                $productId[] = $value;
            }
            foreach (explode(',',$product_name) as $value) {
                $productName[] = $value;
            }
            foreach (explode(',',$price) as $value) {
                $productPrice[] = $value;
            }
            foreach (explode(',',$quantity) as $value) {
                $quantities[] = $value;
            }
            foreach (explode(',',$posSubtotal) as $value) {
                $posSubTotal[] = $value;
            }
        }

        $productDetail = [
            "product_id" =>$productId,
            "product_name" =>$productName,
            "product_price" =>$productPrice,
            "product_quantity" =>$quantities,
            "pos_subtotal" =>$posSubTotal,
        ];

        foreach ($productDetail["product_id"] as $key => $value) {
            $ordersProducts = new OrderProduct;
            $products = Product::with('category')->where('id', $value)->get();
            if ($data['orders_id'] != '') {
              $Orders = Orders::where('id', $data['orders_id'])->latest()->firstOrFail();
            }else {
              $Orders = Orders::where(['created_at' => now(), 'author' => Auth::id()])->latest()->firstOrFail();
            }
            $procur_product = ProcurementsProduct::with('procurement')->where('product_id', $value)->get();
            $in_orders_product = OrderProduct::where(["orders_id" => $data['orders_id'], "author_id" => Auth::id()])->first();
            $productHistories = new ProductHistory;
            $inventories = new Inventory;

            foreach ($procur_product as $product_det) {
                $purchase_price = $product_det->purchase_price;
                $ordersProducts->procurement_product_id = $product_det->procurement_id;
                $ordersProducts->purchase_price = $purchase_price;
                $productHistories->purchase_price = $purchase_price;
            }
            foreach ($products as $product) {
                $productCatId = $product->category->id;
                $ordersProducts->product_category_id = $productCatId;
            }

            if (!$in_orders_product) {
                $ordersProducts->product_id = $value;
                $ordersProducts->orders_id = $Orders->id;
                $ordersProducts->product_name = $productDetail["product_name"][$key];
                $ordersProducts->quantity = $productDetail["product_quantity"][$key];
                $ordersProducts->unit_price = $productDetail["product_price"][$key];
                $ordersProducts->pos_subtotal = $productDetail["pos_subtotal"][$key];
                $ordersProducts->author_id = Auth::id();

                $ordersProducts->save();

            }


            // Product History
            $procurementProductDetails = ProcurementsProduct::where('product_id', $value)->latest()->firstOrFail();
            $ProductHistoryDetails = ProductHistory::where('product_id', $value)->latest()->firstOrFail();
            if (!$in_orders_product) {
                $ProductOrderDetails = OrderProduct::where(['product_id' => $value, 'created_at' => now()])->latest()->firstOrFail();
            }else {
                $ProductOrderDetails = OrderProduct::where('orders_id', $data['orders_id'])->latest()->firstOrFail();
            }
            $productHistories->product_name = $productDetail["product_name"][$key];
            $productHistories->procurement_name = "N/A";
            $productHistories->product_id = $value;
            $productHistories->order_id = $ProductOrderDetails->id;
            $productHistories->operation = __('Sold');
            $productHistories->before_quantity = $ProductHistoryDetails->after_quantity;
            $productHistories->quantity = $productDetail["product_quantity"][$key];
            $productHistories->after_quantity = $ProductHistoryDetails->after_quantity - $productDetail["product_quantity"][$key];
            $productHistories->unit_price = $productDetail["product_price"][$key];
            $productHistories->total_price = $productDetail["pos_subtotal"][$key];
            $productHistories->author_id = Auth::id();

            $productHistories->save();


            $product_history_details = ProductHistory::where('product_id', $value)->latest()->firstOrFail();
            $inventories_quantity = $product_history_details->after_quantity;
            Inventory::where('product_id', $value)->update(['after_quantity' => $inventories_quantity]);

        }

        // Cash Flow History
        if (!$in_orders_product) {
            $ordersDetails = OrderProduct::where(['created_at' => now(), 'author_id' => Auth::id()])->get();
            $orders = Orders::where(['created_at' => now(), 'author' => Auth::id()])->firstOrFail();
        }else {
            $ordersDetails = OrderProduct::where(["orders_id" => $data['orders_id'], "author_id" => Auth::id()])->get();
            $orders = Orders::where(['id' => $data['orders_id'], 'author' => Auth::id()])->firstOrFail();
        }

        $expenseCategories = ExpenseCategory::where('account', '001')->firstOrFail();


        $cash_flows = new CashFlow;

        $cash_flows->name = $date_generate.'-00'.rand(1,9);
        $cash_flows->order_id = $orders->id;
        $cash_flows->expense_category_id = $expenseCategories->id;
        $cash_flows->value = $data["total"];
        $cash_flows->operation = 'credit';
        $cash_flows->author_id = Auth::id();

        $cash_flows->save();

        // echo "</pre>"; print_r($date_generate); die;

        $category = ProductCategory::get();
        foreach ($category as $cat) {
            $categoryDetail = $cat;
        }

        $before_purchases_amount = $customersDetail->purchases_amount;
        $purchases_amout = $before_purchases_amount + $orders->total;
        Client::where('name', 'LIKE', '%'.$data["customer"].'%')->update(['purchases_amount' => $purchases_amout]);

        $customer_name = $data["customer"];
        // echo "<pre>"; print_r($purchases_amout); die;
        return view('pages.orders.payment_receipt', compact('ordersDetails', 'categoryDetail', 'orders', 'customer_name'));
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
