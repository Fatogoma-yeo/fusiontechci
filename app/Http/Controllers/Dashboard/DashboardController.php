<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Orders;
// use App\Models\OrderProduct;
use App\Models\OrderInstalment;
use App\Models\ProductHistory;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $userDetails = User::get();

        $current_day = Orders::whereDate('created_at', date('Y-m-d'))
        ->where('tendered', '!=', 0)
        ->where('payment_status', '!=', 'Annulé')
        ->select(
            DB::raw('SUM(tendered) as total_sales')
        )
        ->get();

        $current_days = Orders::where('tendered', '!=', 0)
        ->where('payment_status', '!=', 'Annulé')
        ->select(
            DB::raw('SUM(tendered) as total_sales')
        )
        ->get();
        // if ($current_days !== null) {
        //     $current_day = $current_days;
        // }else {
        //     $current_day = 0;
        // }

        $current_weeks = Orders::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->where('tendered', '!=', 0)
        ->where('payment_status', '!=', 'Annulé')
        ->select(
            DB::raw('SUM(tendered) as sales_total'),
            DB::raw('DATE_FORMAT(created_at,"%W") as day')
        )
        ->groupBy('day')
        ->get();

        $last_weeks = Orders::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
        ->where('tendered', '!=', 0)
        ->where('payment_status', '!=', 'Annulé')
        ->select(
            DB::raw('SUM(tendered) as sales_total'),
            DB::raw('DATE_FORMAT(created_at,"%W") as day')
        )
        ->groupBy('day')
        ->get();

        $current_week_count = $current_weeks->count();
        if ($current_week_count > 0) {
            foreach ($current_weeks as $value) {
                $day_of_currentweek_detail[] = ['day' => $value->day, 'sale' => $value->sales_total];
            }
            $day_of_currentweek_detail = json_encode($day_of_currentweek_detail, true);
        }else {
            $day_of_currentweek_detail = "null";
        }


        $last_week_count = $last_weeks->count();
        if ($last_week_count > 0) {
            foreach ($last_weeks as $value) {
                $day_of_lastweek_detail[] = ['day' =>$value->day, 'sale' =>$value->sales_total];
            }

            $day_of_lastweek_detail = json_encode($day_of_lastweek_detail, true);
        }else {
            $day_of_lastweek_detail = "null";
        }
        // echo "<pre>"; print_r($current_day); die;

        $order_sammary = Orders::limit(15)->latest()->get();

        $expense_sammary = Expense::whereDate('created_at', date('Y-m-d'))
        ->select(
            DB::raw('SUM(value) as total')
        )
        ->get();

        $expenses = Expense::select(
            DB::raw('SUM(value) as total')
        )
        ->get();

        $defective_sammary = ProductHistory::whereDate('created_at', date('Y-m-d'))
        ->where('operation', __('Defective'))
        ->select(
            DB::raw('SUM(total_price) as total')
        )
        ->get();

        $defectives = ProductHistory::where('operation', __('Defective'))
        ->select(
            DB::raw('SUM(total_price) as total')
        )
        ->get();

        $instalment_sammary = OrderInstalment::whereDate('created_at', date('Y-m-d'))
        ->select(
            DB::raw('SUM(amount_unpaid) as instalment')
        )
        ->get();

        $instalments = OrderInstalment::select(
            DB::raw('SUM(amount_unpaid) as total')
        )
        ->get();

        $customersDetails = Client::orderBy('purchases_amount', 'DESC')->limit(10)->get();

        return view('dashboard', compact('current_days', 'current_day','order_sammary','day_of_currentweek_detail','day_of_lastweek_detail', 'userDetails', 'customersDetails', 'expense_sammary', 'expenses', 'defective_sammary', 'defectives', 'instalment_sammary', 'instalments'));
    }
}
