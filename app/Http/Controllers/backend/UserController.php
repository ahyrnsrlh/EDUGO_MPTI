<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        
        // Hitung enrolled courses (berdasarkan orders yang sudah dibayar)
        $enrolledCoursesCount = Order::where('user_id', $user->id)
            ->where('status', 'completed') // Hanya yang sudah dibayar
            ->distinct('course_id')
            ->count('course_id');
        
        // Jika tidak ada yang completed, coba hitung semua orders (untuk backward compatibility)
        if ($enrolledCoursesCount == 0) {
            $enrolledCoursesCount = Order::where('user_id', $user->id)
                ->distinct('course_id')
                ->count('course_id');
        }
        
        // Hitung wishlist courses
        $wishlistCoursesCount = Wishlist::where('user_id', $user->id)->count();
        
        // Hitung total purchase amount (prioritas amount, fallback ke price)
        $totalPurchaseAmount = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');
            
        // Jika amount kosong, gunakan price sebagai fallback
        if ($totalPurchaseAmount == 0) {
            $totalPurchaseAmount = Order::where('user_id', $user->id)
                ->sum('price');
        }
        
        return view('backend.user.index', compact(
            'enrolledCoursesCount',
            'wishlistCoursesCount', 
            'totalPurchaseAmount'
        ));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
    public function myCourses(){
        $user = Auth::user();
        
        // Ambil courses yang sudah dibeli user (enrolled courses)
        $enrolledCourses = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with(['course', 'payment'])
            ->get();
            
        // Jika tidak ada yang completed, ambil semua orders (backward compatibility)
        if ($enrolledCourses->isEmpty()) {
            $enrolledCourses = Order::where('user_id', $user->id)
                ->with(['course', 'payment'])
                ->get();
        }
        
        return view('backend.user.my-courses', compact('enrolledCourses'));
    }
    
    public function messages(){
        $user = Auth::user();
        
        $messages = Message::forUser($user->id)
            ->with('fromUser')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Mark all messages as read when viewed
        Message::forUser($user->id)->unread()->update(['is_read' => true]);
        
        return view('backend.user.messages', compact('messages'));
    }
    
    public function purchaseHistory(){
        $user = Auth::user();
        
        $orders = Order::where('user_id', $user->id)
            ->with(['course', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('backend.user.purchase-history', compact('orders'));
    }
}
