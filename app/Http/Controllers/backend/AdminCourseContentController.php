<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCourseContentController extends Controller
{
    /**
     * Display course content management page
     */
    public function index($courseId)
    {
        $course = Course::with(['sections.lectures'])->findOrFail($courseId);
        
        return view('backend.admin.course-content.index', compact('course'));
    }

    /**
     * Store a new section
     */
    public function storeSection(Request $request, $courseId)
    {
        $request->validate([
            'section_title' => 'required|string|max:255',
        ], [
            'section_title.required' => 'Judul bagian wajib diisi',
            'section_title.max' => 'Judul bagian maksimal 255 karakter',
        ]);

        CourseSection::create([
            'course_id' => $courseId,
            'section_title' => $request->section_title,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bagian kursus berhasil ditambahkan!'
        ]);
    }

    /**
     * Update section
     */
    public function updateSection(Request $request, $courseId, $sectionId)
    {
        $request->validate([
            'section_title' => 'required|string|max:255',
        ], [
            'section_title.required' => 'Judul bagian wajib diisi',
            'section_title.max' => 'Judul bagian maksimal 255 karakter',
        ]);

        $section = CourseSection::where('course_id', $courseId)->findOrFail($sectionId);
        $section->update([
            'section_title' => $request->section_title,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bagian kursus berhasil diperbarui!'
        ]);
    }

    /**
     * Delete section
     */
    public function deleteSection($courseId, $sectionId)
    {
        $section = CourseSection::where('course_id', $courseId)->findOrFail($sectionId);
        $section->delete(); // Will cascade delete lectures

        return response()->json([
            'success' => true,
            'message' => 'Bagian kursus dan semua materi di dalamnya berhasil dihapus!'
        ]);
    }

    /**
     * Store a new lecture
     */
    public function storeLecture(Request $request, $courseId, $sectionId)
    {
        $request->validate([
            'lecture_title' => 'required|string|max:255',
            'url' => 'nullable|url',
            'content' => 'nullable|string',
            'video_duration' => 'nullable|numeric|min:0',
        ], [
            'lecture_title.required' => 'Judul materi wajib diisi',
            'lecture_title.max' => 'Judul materi maksimal 255 karakter',
            'url.url' => 'URL video harus format yang valid',
            'video_duration.numeric' => 'Durasi video harus berupa angka',
            'video_duration.min' => 'Durasi video tidak boleh negatif',
        ]);

        CourseLecture::create([
            'course_id' => $courseId,
            'section_id' => $sectionId,
            'lecture_title' => $request->lecture_title,
            'url' => $request->url,
            'content' => $request->content,
            'video_duration' => $request->video_duration,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil ditambahkan!'
        ]);
    }

    /**
     * Update lecture
     */
    public function updateLecture(Request $request, $courseId, $sectionId, $lectureId)
    {
        $request->validate([
            'lecture_title' => 'required|string|max:255',
            'url' => 'nullable|url',
            'content' => 'nullable|string',
            'video_duration' => 'nullable|numeric|min:0',
        ], [
            'lecture_title.required' => 'Judul materi wajib diisi',
            'lecture_title.max' => 'Judul materi maksimal 255 karakter',
            'url.url' => 'URL video harus format yang valid',
            'video_duration.numeric' => 'Durasi video harus berupa angka',
            'video_duration.min' => 'Durasi video tidak boleh negatif',
        ]);

        $lecture = CourseLecture::where('course_id', $courseId)
                               ->where('section_id', $sectionId)
                               ->findOrFail($lectureId);

        $lecture->update([
            'lecture_title' => $request->lecture_title,
            'url' => $request->url,
            'content' => $request->content,
            'video_duration' => $request->video_duration,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil diperbarui!'
        ]);
    }

    /**
     * Delete lecture
     */
    public function deleteLecture($courseId, $sectionId, $lectureId)
    {
        $lecture = CourseLecture::where('course_id', $courseId)
                               ->where('section_id', $sectionId)
                               ->findOrFail($lectureId);
        $lecture->delete();

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil dihapus!'
        ]);
    }

    /**
     * Reorder sections
     */
    public function reorderSections(Request $request, $courseId)
    {
        $request->validate([
            'section_ids' => 'required|array',
            'section_ids.*' => 'exists:course_sections,id',
        ]);

        foreach ($request->section_ids as $index => $sectionId) {
            CourseSection::where('id', $sectionId)
                         ->where('course_id', $courseId)
                         ->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan bagian berhasil diperbarui!'
        ]);
    }

    /**
     * Reorder lectures within a section
     */
    public function reorderLectures(Request $request, $courseId, $sectionId)
    {
        $request->validate([
            'lecture_ids' => 'required|array',
            'lecture_ids.*' => 'exists:course_lectures,id',
        ]);

        foreach ($request->lecture_ids as $index => $lectureId) {
            CourseLecture::where('id', $lectureId)
                         ->where('course_id', $courseId)
                         ->where('section_id', $sectionId)
                         ->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan materi berhasil diperbarui!'
        ]);
    }
}
