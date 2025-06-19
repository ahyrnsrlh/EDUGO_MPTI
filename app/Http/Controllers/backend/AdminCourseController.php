<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseGoal;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_courses = Course::latest()->with('user', 'category')->get();
        return view('backend.admin.course.index', compact('all_courses'));
    }

     public function courseStatus(Request $request)
    {
        $course = Course::find($request->course_id);

        if ($course) {
            $course->status = $request->status;
            $course->save();

            return response()->json(['success' => true, 'message' => 'Status kursus berhasil diperbarui!']);
        }

        return response()->json(['success' => false, 'message' => 'Kursus tidak ditemukan!']);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $instructors = User::where('role', 'instructor')->where('status', '1')->get();
        
        return view('backend.admin.course.create', compact('categories', 'subcategories', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'instructor_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'selling_price' => 'required|numeric|min:0',
            'course_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'course_name.required' => 'Nama kursus wajib diisi',
            'course_title.required' => 'Judul kursus wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'subcategory_id.required' => 'Sub kategori wajib dipilih',
            'instructor_id.required' => 'Instruktur wajib dipilih',
            'description.required' => 'Deskripsi wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
            'course_image.required' => 'Gambar kursus wajib diupload',
            'course_image.image' => 'File harus berupa gambar',
            'course_image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $course = new Course();
        
        // Handle image upload
        if ($request->hasFile('course_image')) {
            $image = $request->file('course_image');
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            
            // Move file without resizing for now
            $image->move(public_path('upload/course/thambnail'), $imageName);
            $course->course_image = $imageName;
        }

        $course->course_name = $request->course_name;
        $course->course_title = $request->course_title;
        $course->course_name_slug = Str::slug($request->course_name);
        $course->category_id = $request->category_id;
        $course->subcategory_id = $request->subcategory_id;
        $course->instructor_id = $request->instructor_id;
        $course->description = $request->description;
        $course->video_url = $request->video_url;
        $course->label = $request->label;
        $course->duration = $request->duration;
        $course->resources = $request->resources;
        $course->certificate = $request->certificate;
        $course->selling_price = $request->selling_price;
        $course->discount_price = $request->discount_price;
        $course->prerequisites = $request->prerequisites;
        $course->bestseller = $request->bestseller ?? 'no';
        $course->featured = $request->featured ?? 'no';
        $course->highestrated = $request->highestrated ?? 'no';
        $course->status = 0; // Default pending
        
        $course->save();

        // Save course goals if provided
        if ($request->has('course_goals') && is_array($request->course_goals)) {
            foreach ($request->course_goals as $goal) {
                if (!empty(trim($goal))) {
                    CourseGoal::create([
                        'course_id' => $course->id,
                        'goal_name' => trim($goal),
                    ]);
                }
            }
        }

        return redirect()->route('admin.course.index')->with('success', 'Kursus berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::where('id', $id)->with('user', 'category', 'subCategory', 'course_goal')->first();
        return view('backend.admin.course.view', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::with('course_goal')->findOrFail($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $instructors = User::where('role', 'instructor')->where('status', '1')->get();
        
        return view('backend.admin.course.edit', compact('course', 'categories', 'subcategories', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'instructor_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'selling_price' => 'required|numeric|min:0',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'course_name.required' => 'Nama kursus wajib diisi',
            'course_title.required' => 'Judul kursus wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'subcategory_id.required' => 'Sub kategori wajib dipilih',
            'instructor_id.required' => 'Instruktur wajib dipilih',
            'description.required' => 'Deskripsi wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
            'course_image.image' => 'File harus berupa gambar',
            'course_image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $course = Course::findOrFail($id);
        
        // Handle image upload
        if ($request->hasFile('course_image')) {
            // Delete old image
            if ($course->course_image && file_exists(public_path('upload/course/thambnail/'.$course->course_image))) {
                unlink(public_path('upload/course/thambnail/'.$course->course_image));
            }
            
            $image = $request->file('course_image');
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            
            // Move file without resizing for now
            $image->move(public_path('upload/course/thambnail'), $imageName);
            $course->course_image = $imageName;
        }

        $course->course_name = $request->course_name;
        $course->course_title = $request->course_title;
        $course->course_name_slug = Str::slug($request->course_name);
        $course->category_id = $request->category_id;
        $course->subcategory_id = $request->subcategory_id;
        $course->instructor_id = $request->instructor_id;
        $course->description = $request->description;
        $course->video_url = $request->video_url;
        $course->label = $request->label;
        $course->duration = $request->duration;
        $course->resources = $request->resources;
        $course->certificate = $request->certificate;
        $course->selling_price = $request->selling_price;
        $course->discount_price = $request->discount_price;
        $course->prerequisites = $request->prerequisites;
        $course->bestseller = $request->bestseller ?? 'no';
        $course->featured = $request->featured ?? 'no';
        $course->highestrated = $request->highestrated ?? 'no';
        
        $course->save();

        // Update course goals
        // First, delete existing goals
        CourseGoal::where('course_id', $course->id)->delete();
        
        // Then add new goals if provided
        if ($request->has('course_goals') && is_array($request->course_goals)) {
            foreach ($request->course_goals as $goal) {
                if (!empty(trim($goal))) {
                    CourseGoal::create([
                        'course_id' => $course->id,
                        'goal_name' => trim($goal),
                    ]);
                }
            }
        }

        return redirect()->route('admin.course.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        
        // Delete image file
        if ($course->course_image && file_exists(public_path('upload/course/thambnail/'.$course->course_image))) {
            unlink(public_path('upload/course/thambnail/'.$course->course_image));
        }
        
        $course->delete();
        
        return response()->json(['success' => true, 'message' => 'Kursus berhasil dihapus!']);
    }

    /**
     * Update course status
     */
    public function updateStatus(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        $course->status = $request->status;
        $course->save();
        
        $message = $request->status == 1 ? 'Kursus berhasil diaktifkan!' : 'Kursus berhasil dinonaktifkan!';
        
        return response()->json(['success' => true, 'message' => $message]);
    }
}
