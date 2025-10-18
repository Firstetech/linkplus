<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use App\User;
use App\Theme;
use App\Gateway;
use App\Setting;
use App\Currency;
use App\Transaction;
use App\BusinessCard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /** 
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Queries
        $settings = Setting::where('status', 1)->first();
        $config = DB::table('config')->get();
        $currency = Currency::where('iso_code', $config['1']->config_value)->first();
        $thisMonthIncome = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('payment_status', 'Success')->sum('transaction_amount');
        $today_income = Transaction::where('payment_status', 'Success')->whereDate('created_at', Carbon::today())->sum('transaction_amount');
        $overall_users = User::where('role_id', 2)->where('status', 1)->count();
        $today_users = User::where('role_id', 2)->where('status', 1)->whereDate('created_at', Carbon::today())->count();

        // Chart
        $monthIncome = [];
        $monthUsers = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create(date('Y'), $month);
            $endDate = $startDate->copy()->endOfMonth();
            $sales = Transaction::where('payment_status', 'Success')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->sum('transaction_amount');
            $users = User::where('role_id', 2)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
            $monthIncome[$month] = $sales;
            $monthUsers[$month] = $users;
        }
        $monthIncome = implode(',', $monthIncome);
        $monthUsers = implode(',', $monthUsers);

        // Overview chart
        $earnings = [];
        $vcards = [];
        $stores = [];
        for ($_month = 1; $_month <= 12; $_month++) {
            $startDate = Carbon::create(date('Y'), $_month);
            $endDate = $startDate->copy()->endOfMonth();
            $earning = Transaction::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('payment_status', 'Success')->sum('transaction_amount');
            $vcard = BusinessCard::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('card_type', 'vcard')->where('status', 1)->count();
            $store = BusinessCard::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('card_type', 'store')->where('status', 1)->count();
            $earnings[$_month] = $earning;
            $vcards[$_month] = $vcard;
            $stores[$_month] = $store;
        }

        // vCard and store counts
        $cards = BusinessCard::where('status', 1)->get();

        $totalvCards = 0;
        $totalStores = 0;
        for ($i = 0; $i < count($cards); $i++) {
            if ($cards[$i]->card_type == 'vcard') {
                $totalvCards += 1;
            } else { 
                $totalStores += 1;
            }
        }

        $totalEarnings = Transaction::where('payment_status', 'Success')->sum('transaction_amount');

        $earnings = implode(',', $earnings);
        $vcards = implode(',', $vcards);
        $stores = implode(',', $stores);

        // Current week sales
        $currentWeekSales = [];
        for ($j = 0; $j < 7; $j++) {
            if ($j == 0) {
                $currentWeekSales['sum'][0] = Transaction::whereDate('created_at', Carbon::now()->startOfWeek())->where('payment_status', 'Success')->sum('transaction_amount');
            } else {
                $currentWeekSales['sum'][$j] = Transaction::whereDate('created_at', Carbon::now()->startOfWeek()->addDay($j))->where('payment_status', 'Success')->sum('transaction_amount');
            }
        }

        // View
        return view('admin.home', compact('thisMonthIncome', 'today_income', 'overall_users', 'today_users', 'currency', 'settings', 'monthIncome', 'monthUsers', 'earnings', 'vcards', 'stores', 'totalEarnings', 'totalvCards', 'totalStores', 'currentWeekSales'));
    }
}
