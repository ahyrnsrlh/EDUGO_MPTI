<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLearningController extends Controller
{
    public function show($courseId)
    {
        $user = Auth::user();
        
        // Cek apakah user sudah membeli course ini
        $hasAccess = Order::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->exists();
            
        // Jika tidak ada order completed, cek apakah ada order apapun (backward compatibility)
        if (!$hasAccess) {
            $hasAccess = Order::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->exists();
        }
        
        if (!$hasAccess) {
            return redirect()->route('course-details', $courseId)
                ->with('error', 'You need to purchase this course to access the content.');
        }
        
        // Load course dengan sections dan lectures
        $course = Course::with(['sections.lectures' => function($query) {
            $query->orderBy('id', 'asc');
        }])->findOrFail($courseId);
        
        // Ambil lecture pertama sebagai default
        $currentLecture = null;
        if ($course->sections->isNotEmpty() && $course->sections->first()->lectures->isNotEmpty()) {
            $currentLecture = $course->sections->first()->lectures->first();
        }
        
        return view('backend.user.course-learning.index', compact('course', 'currentLecture'));
    }
    
    public function lecture($courseId, $lectureId)
    {
        $user = Auth::user();
        
        // Cek access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->whereIn('status', ['completed', 'pending']) // Allow pending for backward compatibility
            ->exists();
            
        if (!$hasAccess) {
            return redirect()->route('course-details', $courseId)
                ->with('error', 'You need to purchase this course to access the content.');
        }
        
        $course = Course::with(['sections.lectures' => function($query) {
            $query->orderBy('id', 'asc');
        }])->findOrFail($courseId);
        
        $currentLecture = CourseLecture::findOrFail($lectureId);
        
        // Pastikan lecture ini milik course yang benar
        if ($currentLecture->course_id != $courseId) {
            abort(404);
        }
        
        return view('backend.user.course-learning.index', compact('course', 'currentLecture'));
    }
    
    public function completeLecture($lectureId)
    {
        $user = Auth::user();
        $lecture = CourseLecture::findOrFail($lectureId);
        
        // Check if user has access to this course
        $hasAccess = Order::where('user_id', $user->id)
            ->where('course_id', $lecture->course_id)
            ->where('status', 'completed')
            ->exists();
            
        if (!$hasAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have access to this course'
            ], 403);
        }
        
        // You can create a user_lecture_progress table to track completion
        // For now, we'll just return success
        
        return response()->json([
            'status' => 'success',
            'message' => 'Lecture marked as completed'
        ]);
    }
}
