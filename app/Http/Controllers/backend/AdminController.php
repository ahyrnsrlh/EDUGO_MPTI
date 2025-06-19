<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Category;
use App\Models\Payment;

class AdminController extends Controller
{
    public function login()
    {

        return view('backend.admin.login.index');
    }

    public function dashboard()
    {
        // Data statistik untuk dashboard
        $totalUsers = User::where('role', 'user')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 1)->count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::join('payments', 'orders.payment_id', '=', 'payments.id')
                             ->where('payments.status', 'complete')
                             ->sum('payments.total_amount');
        $pendingOrders = Order::join('payments', 'orders.payment_id', '=', 'payments.id')
                              ->where('payments.status', 'pending')
                              ->count();

        // Kursus terbaru
        $recentCourses = Course::with(['user', 'category'])
                              ->latest()
                              ->limit(5)
                              ->get();

        // Pesanan terbaru
        $recentOrders = Order::with(['user', 'payment'])
                            ->latest()
                            ->limit(5)
                            ->get();

        // Data untuk grafik (contoh: 7 hari terakhir)
        $orderStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $orderStats[] = [
                'date' => $date,
                'orders' => Order::whereDate('created_at', $date)->count(),
                'revenue' => Order::join('payments', 'orders.payment_id', '=', 'payments.id')
                                 ->whereDate('orders.created_at', $date)
                                 ->where('payments.status', 'complete')
                                 ->sum('payments.total_amount')
            ];
        }

        return view('backend.admin.dashboard.index', compact(
            'totalUsers',
            'totalInstructors', 
            'totalCourses',
            'activeCourses',
            'totalCategories',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'recentCourses',
            'recentOrders',
            'orderStats'
        ));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
