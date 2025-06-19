<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }

    public function course_goal()
    {
        return $this->hasMany(CourseGoal::class, 'course_id', 'id');
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id')->orderBy('id', 'asc');
    }

    public function getCourseImageAttribute($value)
    {
        if ($value && file_exists(public_path('upload/course/thambnail/' . $value))) {
            return 'upload/course/thambnail/' . $value;
        }
        return 'frontend/images/img-loading.png';
    }
}
