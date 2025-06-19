<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLecture extends Model
{
    protected $guarded = [];
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id', 'id');
    }
}
