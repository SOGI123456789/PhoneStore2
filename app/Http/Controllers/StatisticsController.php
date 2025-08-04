<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    // Thống kê doanh thu theo tuần
    public function revenueWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $revenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total_amount');
        return view('statistics.revenue_week', compact('revenue'));
    }

    // Thống kê doanh thu theo tháng
    public function revenueMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $revenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');
        return view('statistics.revenue_month', compact('revenue'));
    }

    // Thống kê top sản phẩm bán chạy
    public function topProducts()
    {
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(10)
            ->get();
        return view('statistics.top_products', compact('topProducts'));
    }

    // Trang thống kê tổng hợp với lọc tuần/tháng
    public function index(Request $request)
    {
        $filterType = $request->get('filter_type', 'week');
        if ($filterType === 'month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        } elseif ($filterType === 'quarter') {
            $start = Carbon::now()->firstOfQuarter();
            $end = Carbon::now()->lastOfQuarter();
        } elseif ($filterType === 'year') {
            $start = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        } else {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
        }
        $revenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_amount');
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) use ($start, $end) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$start, $end]);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(10)
            ->get();
        return view('statistics.index', compact('revenue', 'topProducts'));
    }
}
