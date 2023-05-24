<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ExpenseCategory;
use App\Http\Requests\Dashboard\Store\ExpenseCategoryRequest;
use App\Http\Requests\Dashboard\Update\UpdatExpenseCategoryRequest;
use Auth;

class ExpensesCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
    {
        $this->middleware('permission:compte_list|compte_create|compte_edit|compte_show|compte_delete', ['only' => ['index','store']]);
        $this->middleware('permission:compte_create', ['only' =>['create','store']]);
        $this->middleware('permission:compte_edit', ['only' =>['edit','update']]);
        $this->middleware('permission:compte_delete', ['only' =>['destroy']]);
    }
    public function index()
    {
        $userDetails = User::get();
        $accounts = ExpenseCategory::paginate(10);
        return view('pages.expenses.categories.index', compact('accounts', 'userDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.expenses.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseCategoryRequest $request)
    {

        $expense_category = new ExpenseCategory;

        $expense_category->name = $request['name'];
        $expense_category->operation = $request['operation'];
        $expense_category->account = $request['account'];

        $expense_category->author_id = Auth::id();

        $expense_category->save();

        return redirect()->back()->with('success', 'le Compte a été enregistré avec succès');
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
     * @param  App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('pages.expenses.categories.edit', compact('expenseCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Dashboard\Update\UpdatExpenseCategoryRequest  $request
     * @param  App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->validated());

        return redirect()->route("expense_categories.index")->with('success', 'Le Compte a été mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return redirect()->back();
    }
}
