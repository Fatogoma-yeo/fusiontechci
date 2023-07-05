<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\CashFlow;
use App\Models\User;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\ProductCategory;
use App\Models\ProductHistory;
use App\Models\Procurement;
use App\Models\ProcurementsProduct;
use Carbon\Carbon;

class ReportsController extends Controller
{

    function __construct()
      {
          $this->middleware('permission:stock_sale', ['only' => ['soldStockReport']]);
          $this->middleware('permission:report_sale', ['only' =>['salesReport']]);
          $this->middleware('permission:product_report', ['only' =>['lowStockReport']]);
          $this->middleware('permission:stock_show', ['only' =>['fluxHistoryReport']]);
          $this->middleware('permission:sales_progress', ['only' =>['salesProgress']]);
          $this->middleware('permission:profit', ['only' =>['profitReport']]);
          $this->middleware('permission:cash_flow', ['only' =>['cashFlowReport']]);
      }

    public function currency($amount)
    {
        return 'F CFA ' .number_format($amount);
    }

    public function salesReport(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $startDate = $data['startDate'];
            $endDate = Carbon::createFromFormat('Y-m-d', $data['endDate']);
            // echo "<pre>"; print_r($startDate); die;

            $salesReportDetail = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('product_name as product_name'),
                DB::raw('product_category_id as product_category_id'),
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('SUM(discount) as discount'),
                DB::raw('SUM(pos_subtotal) as pos_subtotal'),
            )
            ->groupBy('product_category_id')
            ->groupBy('product_name')
            ->get();
            foreach ($salesReportDetail as $value) {
                $categoryId = $value->product_category_id;
            }
            $salesReports = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('SUM(purchase_price) as subtotal'),
                DB::raw('SUM(discount) as total_discount'),
                DB::raw('SUM(pos_subtotal) as total'),
                DB::raw('SUM(quantity) as quantTotal'),
            )
            ->get();
            $category = ProductCategory::where('id', $categoryId)->get();

            foreach ($category as $key => $category) {
                $category_name = $category->name;
            }

            $output="";
            foreach ($salesReportDetail as $key => $salesReport) {
                $output.=   '<tr>'.
                                '<td class="p-2 border border-gray-500">'.$category_name.'</td>'.
                                '<td class="p-2 border border-gray-500">'.$salesReport->product_name.'</td>'.
                                '<td class="p-2 border border-gray-500 text-right">'.$salesReport->quantity.'</td>'.
                                '<td class="p-2 border border-gray-500 text-right uppercase">'.$this->currency($salesReport->discount).'</td>'.
                                '<td class="p-2 border border-gray-500 text-right uppercase">'.$this->currency($salesReport->pos_subtotal).'</td>'.
                            '</tr>';
            }

            return response()->json(['salesReports' => $salesReports, 'salesReportDetail' => $output, 'category' => $category]);
        }
        return view('pages.reports.sales-reports');
    }

    public function salesProgress(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $startDate = $data['startDate'];
            $endDate = Carbon::createFromFormat('Y-m-d', $data['endDate']);
            // echo "<pre>"; print_r($startDate); die;

            $salesProgressDetail = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('product_name as product_name'),
                DB::raw('SUM(quantity) as old_quantity'),
                DB::raw('SUM(pos_subtotal) as pos_subtotal'),
            )
            ->groupBy('product_name')
            ->get();

            $output="";
            foreach ($salesProgressDetail as $key => $salesProgress) {
                $output.= "<tr class='bg-success-primary'>".
                                "<td class='p-2 border border-gray-500'>".$salesProgress->product_name."</td>".
                                "<td class='p-2 border border-gray-500 text-right'>".
                                    "<div class='flex flex-col'>".
                                        "<span>".
                                            "<span>".$salesProgress->old_quantity."</span>".
                                        "</span>".
                                        "<span :class='text-green-600' class='text-xs text-green-600'>".
                                            "<span>+</span>".
                                            $salesProgress->old_quantity.
                                        "</span>".
                                    "</div>".
                                "</td>".
                                "<td class='p-2 border border-gray-500  text-right'>".
                                    "<div class='flex flex-col'>".
                                        "<span>".$this->currency($salesProgress->pos_subtotal)."</span>".
                                        "<span :class='text-green-600' class='text-xs text-green-600'>".
                                            "<span>+</span>".
                                                $this->currency($salesProgress->pos_subtotal).
                                        "</span>".
                                    "</div>".
                                "</td>".
                                "<td :class='text-green-600' class='p-2 border border-gray-500  text-right text-green-600'>".
                                    "<span>".
                                    "100%".
                                    "<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5 inline-flex'>".
                                            "<path stroke-linecap='round' stroke-linejoin='round' d='M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18' />".
                                        "</svg>".
                                    "</span>".
                                "</td>".
                            "</tr>";
            }

            return response()->json(['salesProgressDetail' => $output]);
        }
        return view('pages.reports.best-products-report');
    }

    public function lowStockReport()
    {
        $products_detail = Product::with('procurement')->get();

        $products_history = ProductHistory::where("operation", "Vendue")
        ->select(
            DB::raw('SUM(quantity) as quantity'),
            DB::raw('product_name as product_name'),
            DB::raw('product_id as product_id'),
            DB::raw('purchase_price as purchase_price'),
            DB::raw('unit_price as unit_price'),
        )
        ->groupBy('product_name')
        ->groupBy('product_id')
        ->groupBy('purchase_price')
        ->groupBy('unit_price')
        ->get();

        $product_history = ProductHistory::where("operation", "Approvisionné")
        ->select(
            DB::raw('SUM(quantity) as quantity'),
            DB::raw('product_id as product_id'),
        )
        ->groupBy('product_id')
        ->get();


        // echo "<pre>"; print_r($products_history); die;
        return view('pages.reports.low-stock-report', compact('products_detail', 'products_history', 'product_history'));
    }

    public function soldStockReport(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $startDate = $data['startDate'];
            $endDate = Carbon::createFromFormat('Y-m-d', $data['endDate']);
            // echo "<pre>"; print_r($startDate); die;

            $stockReportDetail = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('product_name as product_name'),
                DB::raw('SUM(quantity) as old_quantity'),
                DB::raw('SUM(pos_subtotal) as pos_subtotal'),
            )
            ->groupBy('product_name')
            ->get();
            $stockReportTotal = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('SUM(pos_subtotal) as pos_total'),
            )
            ->get();

            $output="";
            foreach ($stockReportDetail as $key => $stockReport) {
                $output.=   '<tr>'.
                                '<td class="p-2 border border-gray-500">'.$stockReport->product_name.'</td>'.
                                '<td class="p-2 border border-gray-500 text-right">'.$stockReport->old_quantity.'</td>'.
                                '<td class="p-2 border border-gray-500 text-right">'.$this->currency($stockReport->pos_subtotal).'</td>'.
                            '</tr>';
            }
            return response()->json(['stockReportDetail' => $output, 'stockReportTotal' => $stockReportTotal]);
        }
        return view('pages.reports.sold-stock-report');
    }

    public function profitReport(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $startDate = $data['startDate'];
            $endDate = Carbon::createFromFormat('Y-m-d', $data['endDate']);
            // echo "<pre>"; print_r($startDate); die;

            $profitTotal = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->get();
            $profitReportDetail = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->get();
            $profitReportTotal = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('SUM(quantity) as quantity_total'),
                DB::raw('SUM(pos_subtotal) as pos_total'),
                DB::raw('SUM(purchase_price) as purchase_price_total'),
            )
            ->get();

            $products_unit = ProcurementsProduct::get();

            $output="";
            foreach ($profitReportDetail as $key => $profitReport) {
                $output.=   '<tr>'.
                                '<td class="p-2 border border-cyan-700">'.$profitReport->product_name.'</td>'.
                                '<td class="p-2 border text-right border-cyan-700">'.$profitReport->quantity.'</td>'.
                                '<td class="p-2 border text-right border-cyan-700">'.$this->currency($profitReport->purchase_price).'</td>'.
                                '<td class="p-2 border text-right border-cyan-700">'.$this->currency($profitReport->pos_subtotal).'</td>'.
                                '<td class="p-2 border text-right text-green-600 border-cyan-700">'.$this->currency( $profitReport->pos_subtotal - $profitReport->purchase_price * $profitReport->quantity ).'</td>'.
                            '</tr>';
            }

            return response()->json(['profitReportDetail' => $output, 'profitReportTotal' => $profitReportTotal, 'product_unit_price' => $products_unit, 'profit_total' => $profitTotal]);
        }
        return view('pages.reports.profit-report');
    }

    public function cashFlowReport(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $startDate = $data['startDate'];
            $endDate = Carbon::createFromFormat('Y-m-d', $data['endDate']);
            // echo "<pre>"; print_r($startDate); die;

            $expense_details = ExpenseCategory::get();
            $cash_flow_details = CashFlow::whereBetween('created_at', [$startDate, $endDate])->Where('status', 'active')
            ->select(
                DB::raw('SUM(value) as value'),
                DB::raw('expense_category_id as category_id'),
            )
            ->groupBy('category_id')
            ->get();

            $output="";
            foreach ($expense_details as $expense_detail) {
                foreach ($cash_flow_details as $cash_flow) {
                  if ($expense_detail->id == $cash_flow->category_id) {
                      $cashsum = $cash_flow->value;
                  }
                }
                $output.=   '<tr>'.
                                  '<td class="p-2 border border-gray-500">'.
                                      '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">'.
                                          '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />'.
                                      '</svg>'.
                                      '<strong>'.$expense_detail->account.'</strong> : '.$expense_detail->name.'
                                   </td>'.
                                  '<td class="p-2 border border-red-400 bg-red-200 text-right">';
                                      if($expense_detail->operation == "debit") { $output .= $this->currency($cashsum).'<span class="hidden" id="debitCompte">'.$cashsum.'</span>'; }else { $output .= $this->currency(0).'<span class="hidden" id="debitCompte">0</span>'; }
                      $output .=  '</td>'.
                                  '<td class="p-2 border text-right border-green-600 bg-green-200">';
                                      if($expense_detail->operation == "credit") { $output .= $this->currency($cashsum).'<span class="hidden" id="creditCompte">'.$cashsum.'</span>'; }else { $output .= $this->currency(0).'<span class="hidden" id="creditCompte">0</span>'; }
                      $output .=  '</td>'.
                              '</tr>';
            }

            return response()->json(['cashflow' => $output]);
        }


        return view('pages.reports.cash-flow');

    }

    public function fluxHistoryReport()
    {
        $userDetails = User::get();
        $productsHistoryReport = ProductHistory::latest()->paginate(10);
        return view('pages.reports.flux-history', compact('productsHistoryReport', 'userDetails'));
    }
}
