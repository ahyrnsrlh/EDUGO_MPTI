<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseGoal;
use Illuminate\Http\Request;

class AdminCourseGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $goals = CourseGoal::where('course_id', $courseId)->latest()->get();
        
        return view('backend.admin.course-goal.index', compact('course', 'goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('backend.admin.course-goal.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'goal_name' => 'required|string|max:500',
        ], [
            'goal_name.required' => 'Tujuan pembelajaran wajib diisi',
            'goal_name.max' => 'Tujuan pembelajaran maksimal 500 karakter',
        ]);

        CourseGoal::create([
            'course_id' => $courseId,
            'goal_name' => $request->goal_name,
        ]);

        return redirect()->route('admin.course.goals.index', $courseId)
            ->with('success', 'Tujuan pembelajaran berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courseId, $goalId)
    {
        $course = Course::findOrFail($courseId);
        $goal = CourseGoal::where('course_id', $courseId)->findOrFail($goalId);
        
        return view('backend.admin.course-goal.edit', compact('course', 'goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $courseId, $goalId)
    {
        $request->validate([
            'goal_name' => 'required|string|max:500',
        ], [
            'goal_name.required' => 'Tujuan pembelajaran wajib diisi',
            'goal_name.max' => 'Tujuan pembelajaran maksimal 500 karakter',
        ]);

        $goal = CourseGoal::where('course_id', $courseId)->findOrFail($goalId);
        $goal->update([
            'goal_name' => $request->goal_name,
        ]);

        return redirect()->route('admin.course.goals.index', $courseId)
            ->with('success', 'Tujuan pembelajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, $goalId)
    {
        $goal = CourseGoal::where('course_id', $courseId)->findOrFail($goalId);
        $goal->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Tujuan pembelajaran berhasil dihapus!'
        ]);
    }

    /**
     * Store multiple goals via AJAX
     */
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'goals' => 'required|array|min:1',
            'goals.*' => 'required|string|max:500',
        ], [
            'course_id.required' => 'ID kursus wajib ada',
            'goals.required' => 'Minimal satu tujuan pembelajaran harus diisi',
            'goals.*.required' => 'Tujuan pembelajaran tidak boleh kosong',
            'goals.*.max' => 'Tujuan pembelajaran maksimal 500 karakter',
        ]);

        // Delete existing goals for this course
        CourseGoal::where('course_id', $request->course_id)->delete();

        // Add new goals
        foreach ($request->goals as $goal) {
            if (!empty(trim($goal))) {
                CourseGoal::create([
                    'course_id' => $request->course_id,
                    'goal_name' => trim($goal),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Tujuan pembelajaran berhasil disimpan!'
        ]);
    }
}
