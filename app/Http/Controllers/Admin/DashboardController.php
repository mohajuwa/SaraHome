<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $metrics = [
            'clients' => User::where('role', 'client')->count(),
            'active' => Project::where('status', '!=', 'completed')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'satisfaction' => 4.8,
        ];

        // Simple weekly activity series for the chart (last 7 days by created_at).
        $week = collect(range(6, 0))->map(function ($daysAgo) {
            $day = now()->subDays($daysAgo);

            return [
                'label' => $day->translatedFormat('D'),
                'count' => Project::whereDate('created_at', $day->toDateString())->count(),
            ];
        });

        // Give the chart some shape even before real traffic exists.
        $activity = $week->pluck('count')->sum() > 0
            ? $week
            : collect([33, 50, 39, 68, 58, 87, 74])->map(fn ($v, $i) => [
                'label' => now()->subDays(6 - $i)->translatedFormat('D'),
                'count' => $v,
            ]);

        // ---- Store sales report ----
        $sales = [
            'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'orders' => Order::count(),
            'new' => Order::where('status', 'new')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        $topProducts = OrderItem::select('name', DB::raw('SUM(qty) as sold'), DB::raw('SUM(price * qty) as revenue'))
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'cancelled'))
            ->groupBy('name')
            ->orderByDesc('sold')
            ->take(4)
            ->get();

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'activity' => $activity,
            'requests' => Project::with('user')->latest()->take(5)->get(),
            'sales' => $sales,
            'topProducts' => $topProducts,
        ]);
    }

    public function settings(): View
    {
        return view('admin.settings');
    }
}
