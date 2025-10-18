<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Setting;
use App\Currency;
use Carbon\Carbon;
use App\BusinessCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Plan;
use App\Visitor;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        $plan = User::where('user_id', Auth::user()->user_id)->first();
        $active_plan = json_decode($plan->plan_details);
        $settings = Setting::where('status', 1)->first();
        $business_card = BusinessCard::where('user_id', Auth::user()->user_id)->count();
        $remaining_days = 0;

        if ($active_plan != null) {
            if (isset($active_plan)) {
                $plan_validity = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', Auth::user()->plan_validity);
                $current_date = Carbon::now();
                $remaining_days = $current_date->diffInDays($plan_validity, false);
            }

            $monthCards = [];
            for ($month = 1; $month <= 12; $month++) {
                $startDate = Carbon::create(date('Y'), $month);
                $endDate = $startDate->copy()->endOfMonth();
                $cards = BusinessCard::where('user_id', Auth::user()->user_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
                $monthCards[$month] = $cards;
            }
            $monthCards = implode(',', $monthCards);

            // Overview chart
            $vcards = [];
            $stores = [];
            for ($_month = 1; $_month <= 12; $_month++) {
                $startDate = Carbon::create(date('Y'), $_month);
                $endDate = $startDate->copy()->endOfMonth();
                $vcard = BusinessCard::where('user_id', Auth::user()->user_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('card_type', 'vcard')->where('status', 1)->count();
                $store = BusinessCard::where('user_id', Auth::user()->user_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('card_type', 'store')->where('status', 1)->count();
                $vcards[$_month] = $vcard;
                $stores[$_month] = $store;
            }

            // vCard and store counts
            $cards = BusinessCard::where('user_id', Auth::user()->user_id)->where('status', 1)->get();

            $totalvCards = 0;
            $totalStores = 0;
            for ($i = 0; $i < count($cards); $i++) {
                if ($cards[$i]->card_type == 'vcard') {
                    $totalvCards += 1;
                } else {
                    $totalStores += 1;
                }
            }

            $vcards = implode(',', $vcards);
            $stores = implode(',', $stores);

            // Top 5 Platforms
            $platforms = Visitor::select('visitors.platform', DB::raw('count(*) as total'))->groupBy('visitors.platform')->where('visitors.status', "1")->get();

            $_platforms = collect($platforms)->sortBy('total')->reverse()->toArray();
            $_platforms = array_values($_platforms);

            $highestPlatforms = [];

            if (count($_platforms) > 0) {
                for ($j = 0; $j < count($_platforms); $j++) {
                    if ($j < 5) {
                        if (isset($_platforms[$j])) {
                            $highestPlatforms['platform'][] = $_platforms[$j]['platform'];
                            $highestPlatforms['count'][] = $_platforms[$j]['total'];
                        }
                    }
                }
            } else {
                $highestPlatforms['platform'][] = '';
                $highestPlatforms['count'][] = 100;
            }

            // Top 5 Devices
            $devices = Visitor::select('visitors.device', DB::raw('count(*) as total'))->groupBy('visitors.device')->where('visitors.status', "1")->get();

            $_devices = collect($devices)->sortBy('total')->reverse()->toArray();
            $_devices = array_values($_devices);

            $highestDevices = [];

            if (count($_devices) > 0) {
                for ($m = 0; $m < count($_devices); $m++) {
                    if ($m < 5) {
                        if (isset($_devices[$m])) {
                            $highestDevices['device'][] = $_devices[$m]['device'];
                            $highestDevices['count'][] = $_devices[$m]['total'];
                        }
                    }
                }
            } else {
                $highestDevices['device'][] = '';
                $highestDevices['count'][] = 100;
            }

            // Top 10 vCards & Stores
            $cards = Visitor::select('visitors.card_id', DB::raw('count(*) as total'))->groupBy('visitors.card_id')->where('visitors.status', "1")->get();

            $_cards = collect($cards)->sortBy('total')->reverse()->toArray();
            $_cards = array_values($_cards);

            $highestCards = [];
            for ($k = 0; $k < count($_cards); $k++) {
                if ($k < 10) {
                    $highestCards[$k]['card'] = $_cards[$k]['card_id'];
                    $highestCards[$k]['count'] = $_cards[$k]['total'];
                }
            }

            // Current week vcards visitors
            $currentWeekVisitors = [];
            for ($l = 0; $l < 7; $l++) {
                if ($l == 0) {
                    $currentWeekVisitors['vcard'][0] = Visitor::whereDate('created_at', Carbon::now()->startOfWeek())->where('visitors.type', "vcard")->where('visitors.status', "1")->count();
                    $currentWeekVisitors['store'][0] = Visitor::whereDate('created_at', Carbon::now()->startOfWeek())->where('visitors.type', "store")->where('visitors.status', "1")->count();
                } else {
                    $currentWeekVisitors['vcard'][$l] = Visitor::whereDate('created_at', Carbon::now()->startOfWeek()->addDay($l))->where('visitors.type', "vcard")->where('visitors.status', "1")->count();
                    $currentWeekVisitors['store'][$l] = Visitor::whereDate('created_at', Carbon::now()->startOfWeek()->addDay($l))->where('visitors.type', "store")->where('visitors.status', "1")->count();
                }
            }

            return view('user.home', compact('settings', 'active_plan', 'remaining_days', 'business_card', 'monthCards', 'vcards', 'stores', 'totalvCards', 'totalStores', 'highestPlatforms', 'highestCards', 'currentWeekVisitors', 'highestDevices'));
        } else {
            return redirect()->route('user.plans');
        }
    }
}
