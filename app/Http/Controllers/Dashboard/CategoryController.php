<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Store\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Update\UpdateCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   function __construct()
    {
        $this->middleware('permission:categories_access|categories_create|categories_edit|categories_show|categories_delete', ['only' => ['index','store']]);
        $this->middleware('permission:categories_create', ['only' =>['create','store']]);
        $this->middleware('permission:categories_edit', ['only' =>['edit','update']]);
        $this->middleware('permission:categories_delete', ['only' =>['destroy']]);
    }
    public function index()
    {
        $userDetails = User::get();
        $categories = ProductCategory::orderBy('id', 'DESC')->paginate(5);
        $parentCategory = ProductCategory::where('parent_id', null)->get();

        return view('pages.categories.index', compact('categories', 'parentCategory', 'userDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::get();
        return view('pages.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $fields = $request->only([ 'name', 'parent_id', 'media' ]);

        $category = new ProductCategory;

        if (!empty($fields['media'])) {
            if($request->hasFile('media')){
                $image_tmp = $request->file('media');
                if($image_tmp->isValid()){
                    $extension = time().$image_tmp->getClientOriginalExtension();
                    $file_name = rand(111,99999).'.'.$extension;
                    $path = $image_tmp->storeAs('images/category', $file_name, 'public');
                    $fields['media'] = '/storage/'.$path;
                    $category->media = $file_name;
                }
            }
        }else {
            $category->media = '';
        }

        foreach ( $fields as $name => $field ) {
            $category->$name = $field;
        }

        $category->author_id = Auth::id();
        $category->save();

        return redirect()->back()->with('success', 'Categorie enregistrer avec succès !');
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
     * @param  App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request,ProductCategory $category)
    {
        $category = ProductCategory::find( $category->id );

        $fields = $request->only([ 'name', 'parent_id', 'displays_on_pos', 'media_id' ]);

        foreach ( $fields as $name => $field ) {
            $category->$name = $field;
        }

        $category->author_id = Auth::id();
        $category->update();

        return redirect()->back()->with('success', 'La catégorie a été mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()->back();
    }
}
