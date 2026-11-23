<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $selectedYear = (int) request('year', now()->year);

        $bestSeller = Order::query()
            ->whereMonth('created_at' , now()->month)
            ->whereYear('created_at' , now()->year)
            ->selectRaw('user_id , SUM(total) as total_spent')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->with('user')
            ->first();

        $lastMonth = now()->subMonth();

        $totalRevenue = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total');

        $totalCustomers = User::where('is_admin', false)
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $totalProducts = Product::count();

        $totalSales =  Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $currentMonth = now();
        $lastMonth    = now()->subMonth();

        $clientsCurrentMonth = User::where('is_admin', false)
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $clientsLastMonth = User::where('is_admin', false)
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $ordersCurrentMonth = Order::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $ordersLastMonth = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();


        $monthlyOrders = Order::whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total','month');

        $monthlySales = Order::whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->pluck('total','month');

        $monthlyProfit = Order::whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $fillMonths = fn($data) => collect(range(1, 12))->map(fn($m) => (float) ($data[$m] ?? 0))->values();

        $ordersMonthly = $fillMonths($monthlyOrders);
        $salesMonthly  = $fillMonths($monthlySales);
        $profitMonthly = $fillMonths($monthlyProfit);


        $totalOrders = Order::whereYear('created_at', $selectedYear)->count();

        $totalClients = User::where('is_admin', false)
            ->whereYear('created_at', $selectedYear)
            ->count();

        $totalProfit = Order::whereYear('created_at', $selectedYear)->sum('total');

        $firstOrderYear = Order::min('created_at')
            ? Carbon::parse(Order::min('created_at'))->year
            : now()->year;

        $availableYears = collect(range(now()->year, $firstOrderYear))->values();



        $selectedReportYear  = (int) request('report_year', now()->year);
        $selectedReportMonth = (int) request('report_month', now()->month);
        $selectedBranchId    = request('branch_id'); // null = كل الفروع

        $branches = Branch::orderBy('name')->get();

        $daysInMonth = Carbon::createFromDate($selectedReportYear, $selectedReportMonth, 1)->daysInMonth;

        $dailyBaseQuery = Order::whereYear('created_at', $selectedReportYear)
            ->whereMonth('created_at', $selectedReportMonth);

        if ($selectedBranchId) {
            $dailyBaseQuery->where('branch_id', $selectedBranchId);
        }

        $dailyOrdersRaw = (clone $dailyBaseQuery)
            ->selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $dailySalesRaw = (clone $dailyBaseQuery)
            ->selectRaw('DAY(created_at) as day, SUM(total) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $fillDays = fn($data, $days) => collect(range(1, $days))->map(fn($d) => (float) ($data[$d] ?? 0))->values();

        $dailyOrders = $fillDays($dailyOrdersRaw, $daysInMonth);
        $dailySales  = $fillDays($dailySalesRaw, $daysInMonth);

        $monthlyReportTotalOrders = (int) $dailyOrders->sum();
        $monthlyReportTotalSales  = (float) $dailySales->sum();

        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $compareYearA = (int) request('compare_year_a', now()->year);
        $compareYearB = (int) request('compare_year_b', now()->year - 1);

        $clientsCompareA = User::where('is_admin', false)
            ->whereYear('created_at', $compareYearA)
            ->count();

        $clientsCompareB = User::where('is_admin', false)
            ->whereYear('created_at', $compareYearB)
            ->count();

        $ordersCompareA = Order::whereYear('created_at', $compareYearA)->count();
        $ordersCompareB = Order::whereYear('created_at', $compareYearB)->count();

        $popularProducts = Product::popular()
            ->with(['industry:id,name', 'categories:id,name'])
            ->withMin('variants as min_price', 'price')
            ->withSum('variants as total_stock', 'stock_quantity')
            ->take(10)
            ->get();

        $topOrders = Order::with(['user:id,first_name,last_name,photo', 'branch:id,name'])
            ->withCount('items')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderByDesc('total')
            ->take(10)
            ->get();

        return view('pages.home' , compact('totalRevenue','totalCustomers','totalProducts','totalSales','bestSeller',
            'clientsCurrentMonth' , 'clientsLastMonth', 'ordersCurrentMonth',
            'ordersLastMonth' ,'ordersMonthly' , 'salesMonthly', 'profitMonthly','totalOrders',
            'totalClients','totalProfit','selectedYear', 'availableYears',
            'branches', 'selectedReportYear', 'selectedReportMonth', 'selectedBranchId',
            'dailyOrders', 'dailySales', 'daysInMonth',
            'monthlyReportTotalOrders', 'monthlyReportTotalSales', 'monthNames',
            'compareYearA', 'compareYearB', 'clientsCompareA', 'clientsCompareB', 'ordersCompareA', 'ordersCompareB' ,'popularProducts',
            'topOrders'
        ));
    }

    public function show()
    {
        return view('pages.profile');
    }
}
