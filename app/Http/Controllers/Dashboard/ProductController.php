<?php

namespace App\Http\Controllers\Dashboard;

use Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Store\StoreProductRequest;
use App\Http\Requests\Dashboard\Update\UpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\ProductHistory;
use App\Models\ProcurementsProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OwnerNotificate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
         $this->middleware('permission:products_access|products_create|products_edit|products_show|products_delete', ['only' => ['index','store']]);
         $this->middleware('permission:products_create', ['only' =>['create','store']]);
         $this->middleware('permission:products_edit', ['only' =>['edit','update']]);
         $this->middleware('permission:products_delete', ['only' =>['destroy']]);
         $this->middleware('permission:ajust_stock', ['only' =>['showStockAdjustment']]);
     }

    public function index()
    {
        $userDetails = User::get();
        $products = Product::with('category')->latest()->paginate(5);

        return view('pages.products.index', compact('products', 'userDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::get();
        return view('pages.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $fields = $request->only([ 'name', 'category_id', 'status', 'media']);

        $product = new Product;

        if (!empty($fields['media'])) {
            if($request->hasFile('media')){
                $image_tmp = $request->file('media');
                if($image_tmp->isValid()){
                    $file_name = rand(111,99999).'.'. 'png';
                    $path = $image_tmp->storeAs('images/product', $file_name, 'public');
                    $fields['media'] = 'storage/'.$path;
                    $product->media = $file_name;
                }
            }
        }else {
            $product->media = '';
        }

        foreach ( $fields as $name => $field ) {
            $product->$name = $field;
        }

        $product->author_id = Auth::id();
        $product->save();
        $productDetails = Product::with('category')->first();
        $category = ProductCategory::where('id', $productDetails->category_id)->first();
        $countProducts = $productDetails->count();
        $category->update(['total_items' => $countProducts]);
        // echo '<pre>';print_r($category); die;

        return redirect()->back()->with('success', 'Le produit a été créer avec succès !');
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

    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output="";
            $products=Product::where('name','LIKE','%'.$request->search."%")->get();

            if ($products) {
                $output = '<ul class="block py-2">';
                    foreach ($products as $key => $product) {
                        $output.= '<li class="border product bg-gray-100 py-2 cursor-pointer shadow-md border-gray-400"><span class="ml-4 text-lg"><input type="text" name="product_id" id="product_id" class="hidden" value='.$product->id.'>'.$product->name.'</span></li>';
                    }
                $output .= '</ul>';

                return Response($output);
            }
        }
    }

    public function showStockAdjustment(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'product_id' => 'required',
                'quantity' => 'required',
            ]);
            if ($validated) {
                $data = $request->all();
                // echo "<pre>"; print_r($data); die;
                foreach ($data['product_id'] as $key => $value) {

                    $procur_product = ProcurementsProduct::with('procurement')->where('product_id', $value)->get();
                    $productHistories = new ProductHistory;

                    foreach ($procur_product as $product_det) {
                        $purchase_price = $product_det->purchase_price;
                        $productHistories->purchase_price = $purchase_price;
                    }

                    $product_detail = Product::where('id', $value)->get();
                    foreach ($product_detail as $product) {
                        $product_name = $product->name;
                    }

                    // Product History
                    $procurementProductDetails = ProcurementsProduct::where('product_id', $value)->latest()->first();
                    $ProductHistoryDetails = ProductHistory::where('product_id', $value)->latest()->first();
                    $productHistories->product_name = $product_name;
                    $productHistories->procurement_name = "N/A";
                    $productHistories->product_id = $value;
                    $productHistories->before_quantity = $ProductHistoryDetails->after_quantity;
                    $productHistories->quantity = $data['quantity'][$key];
                    $productHistories->after_quantity = $ProductHistoryDetails->after_quantity - $data['quantity'][$key];
                    $productHistories->unit_price = $data['unit_price'][$key];
                    $productHistories->total_price = $data['total_price'][$key];
                    $productHistories->author_id = Auth::id();

                    // echo '<pre>';print_r($procurement);die;
                }

                $productHistories->operation = $data['operation'];

                $productHistories->save();

                $users = ['comptabiliter@fusiontechci.com', 'admin@fusiontechci.com'];
                Mail::to($users)->send(new OwnerNotificate());

                return redirect()->back()->with('success', __('The stock has been adjustment successfully.'));
            }
        }

        return view('pages.products.stock-ajustment');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::get();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product)
    {
        $fields = $request->only([ 'name', 'category_id', 'status', 'media']);
        $destination = $product->media;

        if ($destination) {
            unlink(public_path($destination));
        }

        if (!empty($fields['media'])) {
            if($request->hasFile('media')){
                $image_tmp = $request->file('media');
                if($image_tmp->isValid()){
                    $file_name = rand(111,99999).'.'. 'png';
                    $path = $image_tmp->storeAs('images/product', $file_name, 'public');
                    $fields['media'] = 'storage/'.$path;
                    $product->media = $file_name;
                }
            }
        }else {
            unset($fields['media']);
        }

        foreach ( $fields as $name => $field ) {
            $product->$name = $field;
        }

        $product->author_id = Auth::id();
        $product->update();

        return redirect()->back()->with('success', 'Le produit a été mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        unlink(public_path($product->media));

        return redirect()->back()->with('success', 'Le produit a été supprimer avec succès !');
    }
}
