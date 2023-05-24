<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ProductHistory;
use App\Models\CashFlow;
use App\Http\Requests\Dashboard\Store\ExpenseRequest;
use App\Http\Requests\Dashboard\Update\UpdatExpenseRequest;
use Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
     {
         $this->middleware('permission:expense_list|expense_create|expense_edit|expense_show|expense_delete', ['only' => ['index','store']]);
         $this->middleware('permission:expense_create', ['only' =>['create','store']]);
         $this->middleware('permission:expense_edit', ['only' =>['edit','update']]);
         $this->middleware('permission:expense_delete', ['only' =>['destroy']]);
         $this->middleware('permission:cash_flow_show', ['only' =>['cashFlowHistory']]);
     }
    public function index()
    {
        $userDetails = User::get();
        $expenses = Expense::orderBy('id', 'DESC')->paginate(5);

        return view('pages.expenses.index', compact('expenses', 'userDetails'));
    }

    public function cashFlowHistory()
    {
        $userDetails = User::get();
        $cash_flow_history = CashFlow::latest()->paginate(10);
        return view('pages.expenses.cash-flow-history', compact('cash_flow_history', 'userDetails'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userDetails = User::get();
        $categories = ExpenseCategory::get();
        return view('pages.expenses.create', compact('categories', 'userDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $expenses = new Expense;
        $cash_flows = new CashFlow;

        $expenses->name = $request["name"];
        $expenses->value = $request["value"];
        $expenses->category_id = $request["category_id"];
        $expenses->author_id = Auth::id();

        $expenses->save();

        $expenses_details = Expense::where('created_at', Carbon::now())->first();
        $expense_category = ExpenseCategory::where('id', $request["category_id"])->first();

        $cash_flows->name = $request['name'];
        $cash_flows->expense_id = $expenses_details->id;
        $cash_flows->expense_category_id = $request["category_id"];
        $cash_flows->value = $request["value"];
        $cash_flows->operation = $expense_category->operation;
        $cash_flows->author_id = Auth::id();

        $cash_flows->save();

        return redirect()->back()->with('success', 'La dépense a été enregistrée avec succès !');
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
     * @param  App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $categoryDetail = ExpenseCategory::where('id', $expense->category_id)->first();
        $categoryDetail = json_decode($categoryDetail, true);
        $categories = ExpenseCategory::with('category')->get();
        // echo "<pre>"; print_r($categoryDetail); die;
        return view('pages.expenses.edit', compact('expense', 'categories', 'categoryDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return redirect()->route('expenses.index')->with('success', 'La dépense a été moditifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->back()->with('success', 'Suppression de la dépense effectuer avec succès !');
    }
}
