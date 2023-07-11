<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Orders;
use App\Models\OrderProduct;
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

        $current_days = OrderProduct::whereDay('created_at', Carbon::now())
        ->select(
            DB::raw('SUM(pos_subtotal) as total_sales'),
            DB::raw('DATE_FORMAT(created_at,"%W") as day')
        )
        ->groupBy('day')
        ->get();
        // if ($current_days !== null) {
        //     $current_day = $current_days;
        // }else {
        //     $current_day = 0;
        // }

        $current_weeks = OrderProduct::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->select(
            DB::raw('SUM(pos_subtotal) as sales_total'),
            DB::raw('DATE_FORMAT(created_at,"%W") as day')
        )
        ->groupBy('day')
        ->get();

        $last_weeks = OrderProduct::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
        ->select(
            DB::raw('SUM(pos_subtotal) as sales_total'),
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

        $order_sammary = Orders::limit(10)->get();

        $expense_sammary = Expense::whereDay('created_at', Carbon::now())
        ->select(
            DB::raw('SUM(value) as total'),
            DB::raw('DATE_FORMAT(created_at,"%W") as day')
        )
        ->groupBy('day')
        ->get();

        $defective_sammary = ProductHistory::where('operation', __('Defective'))->select(
            DB::raw('SUM(total_price) as dayDefective'),
            DB::raw('DATE_FORMAT(created_at,"%W") as day')
        )
        ->groupBy('day')
        ->get();

        $customersDetails = Client::orderBy('purchases_amount', 'DESC')->get();

        return view('dashboard', compact('current_days','order_sammary','day_of_currentweek_detail','day_of_lastweek_detail', 'userDetails', 'customersDetails', 'expense_sammary', 'defective_sammary'));
    }
}
