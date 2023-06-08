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
use Auth;
use DB;

class OrdersController extends Controller
{
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
           $procurementDetail = ProcurementsProduct::with('product')->where('product_name','LIKE','%'.$request->pos_search."%")->get();
           $products_Detail = Product::with('procurement')->where('name','LIKE','%'.$request->pos_search."%")->get();

           if ($request->pos_search != '') {

               foreach ($procurementDetail as $key => $procurement) {
                       $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                       x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                       <a href="#">
                                           <input type="text" class="hidden" name="product_id" id="product_id" value='.$procurement->product->id.'  >';

                       if($procurement->product->media){
                           $output .= '<img src='.$procurement->product->media.' class="h-full w-full" alt="Image Produits" />';
                       }else {
                           $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                           <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                       </svg>';
                       }

                       $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                       <span class="flex justify-center">
                                           <h2 class="text-sm font-bold">'.$procurement->product->name.'</h2>
                                       </span>
                                       <span class="flex justify-center">
                                           <h3 class="text-sm font-bold">'.
                                             $procurement->net_purchase_price .'F CFA
                                           </h3>
                                         </span>
                                     </div>
                                 </a>
                             </div>';
               }

               foreach ($products_Detail as $key => $product) {
                 if (count($product->procurement) == 0) {
                   $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                   x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                   <a href="#">
                                       <input type="text" class="hidden" name="product_id" id="product_id" value='.$product->id.'  >';

                   if($product->media){
                       $output .= '<img src='.$product->media.' class="h-full w-full" alt="Image Produits" />';
                   }else {
                       $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                   </svg>';
                   }

                   $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                   <span class="flex justify-center">
                                       <h2 class="text-sm font-bold">'.$product->name.'</h2>
                                   </span>
                               </div>
                           </a>
                       </div>';
                 }
               }

               return Response($output);

           }else {

               $output = '';
               $procurementDetail = ProcurementsProduct::with('product')->get();
               $products_Detail = Product::with('procurement')->get();

               foreach ($procurementDetail as $key => $procurement) {
                       $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                       x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                       <a href="#">
                                           <input type="text" class="hidden" name="product_id" id="product_id" value='.$procurement->product->id.'  >';

                       if($procurement->product->media){
                           $output .= '<img src='.$procurement->product->media.' class="h-full w-full" alt="Image Produits" />';
                       }else {
                           $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                           <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                       </svg>';
                       }

                       $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                       <span class="flex justify-center">
                                           <h2 class="text-sm font-bold">'.$procurement->product->name.'</h2>
                                       </span>
                                       <span class="flex justify-center">
                                           <h3 class="text-sm font-bold">'.
                                             $procurement->net_purchase_price .'F CFA
                                           </h3>
                                         </span>
                                     </div>
                                 </a>
                             </div>';
               }

               foreach ($products_Detail as $key => $product) {
                 if (count($product->procurement) == 0) {
                   $output .= '<div class="relative border border-r-0 border-t-0" x-data=""
                                   x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-product\')" onclick="getproductfunc(this)">
                                   <a href="#">
                                       <input type="text" class="hidden" name="product_id" id="product_id" value='.$product->id.'  >';

                   if($product->media){
                       $output .= '<img src='.$product->media.' class="h-full w-full" alt="Image Produits" />';
                   }else {
                       $output .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                   </svg>';
                   }

                   $output .=' <div class="absolute bottom-0 flex flex-col bg-gray-200 opacity-75 px-1 shadow-md w-full h-20 py-2 text-center">
                                   <span class="flex justify-center">
                                       <h2 class="text-sm font-bold">'.$product->name.'</h2>
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
            PosList::where(['product_id' => $data['product_id'], 'author_id' => Auth::id()])->update(['quantity' => $data['quantity']]);

            $productsDetails = PosList::where('author_id', Auth::id())->get();
            $productsDetails = json_decode($productsDetails, true);
            return view('pages.orders.products', compact('productsDetails'));
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
            $procur_product = ProcurementsProduct::with('procurement')->where('product_id', $value)->get();
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
            $ordersProducts->product_id = $value;
            $ordersProducts->product_name = $productDetail["product_name"][$key];
            $ordersProducts->quantity = $productDetail["product_quantity"][$key];
            $ordersProducts->unit_price = $productDetail["product_price"][$key];
            $ordersProducts->pos_subtotal = $productDetail["pos_subtotal"][$key];
            $ordersProducts->author_id = Auth::id();

            $ordersProducts->save();

            $orderDetail = OrderProduct::where('created_at', now())->get();
            foreach ($orderDetail as $order_detail) {
                $order_id = $order_detail->id;
                $orders = $order_detail;
            }


            // Product History
            $procurementProductDetails = ProcurementsProduct::where('product_id', $value)->latest()->firstOrFail();
            $ProductHistoryDetails = ProductHistory::where('product_id', $value)->latest()->firstOrFail();
            $ProductOrderDetails = OrderProduct::where('product_id', $value)->latest()->firstOrFail();
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


            $ProductsHistoryDetails = ProductHistory::where('product_id', $value)->latest()->firstOrFail();
            $inventories_quantity = $ProductsHistoryDetails->after_quantity;
            Inventory::where('product_id', $value)->update(['after_quantity' => $inventories_quantity]);

        }

        // Cash Flow History

        $orders_details = OrderProduct::where('created_at', now())->firstOrFail();
        $expenseCategories = ExpenseCategory::where('account', '001')->firstOrFail();


        $cash_flows = new CashFlow;

        $date_generate = DATE_FORMAT(now(), 'dmy');

        $cash_flows->name = $date_generate.'-00'.rand(1,9);
        $cash_flows->order_id = $orders_details->id;
        $cash_flows->expense_category_id = $expenseCategories->id;
        $cash_flows->value = $data["total"];
        $cash_flows->operation = 'credit';
        $cash_flows->author_id = Auth::id();

        $cash_flows->save();


        $customersDetail = Client::where('name', 'LIKE', '%'.$data["customer"].'%')->firstOrFail();

        $order = new Orders;

        $order->payment_status = "paid";
        $order->discount = $data['discount'];
        $order->subtotal = $data['subtotal'];
        $order->total = $data['total'];
        $order->customer_id = $customersDetail->id;
        $order->author = Auth::id();

        $order->save();
        // echo "</pre>"; print_r($date_generate); die;

        $category = ProductCategory::get();
        foreach ($category as $cat) {
            $categoryDetail = $cat;
        }

        $ordersDetails = OrderProduct::where('created_at', now())->get();
        $orders = Orders::where('created_at', now())->firstOrFail();

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
