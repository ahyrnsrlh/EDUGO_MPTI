@extends('backend.user.master')

@section('content')

<div class="course-learning-container">
    <div class="row">
        <!-- Course Content -->
        <div class="col-lg-8">
            <div class="card card-item">
                @if($currentLecture)
                    <div class="card-header">
                        <h4 class="card-title">{{ $currentLecture->lecture_title }}</h4>
                        <div class="lecture-meta">                            <span class="badge badge-primary">
                                Bagian: {{ $currentLecture->section->section_title ?? 'Tidak Diketahui' }}
                            </span>
                            @if($currentLecture->video_duration)
                                <span class="badge badge-secondary ml-2">
                                    Durasi: {{ $currentLecture->video_duration }} menit
                                </span>
                            @endif
                        </div>
                    </div>                    <div class="card-body p-0">
                        @if($currentLecture->url)
                            <div class="video-container-wrapper">
                                @if(Str::contains($currentLecture->url, ['youtube.com', 'youtu.be']))
                                    @php
                                        $videoId = '';
                                        // Extract video ID from different YouTube URL formats
                                        if (Str::contains($currentLecture->url, 'youtube.com/embed/')) {
                                            $videoId = Str::after($currentLecture->url, 'youtube.com/embed/');
                                            $videoId = Str::before($videoId, '?'); // Remove parameters
                                        } elseif (Str::contains($currentLecture->url, 'youtube.com/watch?v=')) {
                                            $videoId = Str::after($currentLecture->url, 'v=');
                                            $videoId = Str::before($videoId, '&'); // Remove parameters
                                        } elseif (Str::contains($currentLecture->url, 'youtu.be/')) {
                                            $videoId = Str::after($currentLecture->url, 'youtu.be/');
                                            $videoId = Str::before($videoId, '?'); // Remove parameters
                                        }
                                    @endphp
                                    @if($videoId)
                                        <div class="video-player-container">
                                            <div class="video-responsive">
                                                <iframe 
                                                    id="video-player"
                                                    src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&showinfo=0&modestbranding=1&iv_load_policy=3" 
                                                    title="{{ $currentLecture->lecture_title }}"
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="la la-exclamation-triangle"></i>
                                            Video tidak dapat dimuat. ID video tidak valid.
                                        </div>
                                    @endif                                @else
                                    <div class="video-player-container">
                                        <div class="video-responsive">
                                            <video controls class="w-100 h-100">
                                                <source src="{{ $currentLecture->url }}" type="video/mp4">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-info m-4">
                                <i class="la la-info-circle"></i>
                                Kuliah ini hanya berisi konten teks.
                            </div>
                        @endif
                        
                        @if($currentLecture->content)
                            <div class="lecture-content p-4">
                                <h5>Deskripsi Kuliah</h5>
                                <div class="content-text">
                                    {!! nl2br(e($currentLecture->content)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="card-body text-center py-5">
                        <i class="la la-video-play" style="font-size: 3rem; color: #ddd;"></i>                        <h4 class="mt-3">Tidak Ada Konten Tersedia</h4>
                        <p class="text-muted">Kursus ini belum memiliki kuliah apapun.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Course Sidebar -->
        <div class="col-lg-4">
            <div class="card card-item">
                <div class="card-header">
                    <h5 class="card-title">{{ $course->course_name }}</h5>
                    <div class="course-progress">
                        @php
                            $totalLectures = $course->sections->sum(function($section) {
                                return $section->lectures->count();
                            });
                        @endphp
                        <small class="text-muted">{{ $totalLectures }} Kuliah</small>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="course-curriculum">
                        @forelse($course->sections as $section)
                            <div class="curriculum-section">
                                <div class="section-header p-3 bg-light">
                                    <h6 class="mb-0">
                                        <i class="la la-folder-o mr-2"></i>
                                        {{ $section->section_title }}                                        <span class="badge badge-secondary float-right">
                                            {{ $section->lectures->count() }} kuliah
                                        </span>
                                    </h6>
                                </div>
                                
                                @if($section->lectures->count() > 0)
                                    <div class="section-lectures">                                        @foreach($section->lectures as $lecture)
                                            <div class="lecture-item p-3 border-bottom {{ $currentLecture && $currentLecture->id == $lecture->id ? 'active' : '' }}"
                                                 data-lecture-id="{{ $lecture->id }}"
                                                 data-lecture-url="{{ $lecture->url }}"
                                                 data-lecture-title="{{ $lecture->lecture_title }}"
                                                 data-lecture-content="{{ $lecture->content }}">
                                                <a href="{{ route('user.course.lecture', [$course->id, $lecture->id]) }}" 
                                                   class="lecture-link d-block text-decoration-none">
                                                    <div class="d-flex align-items-center">
                                                        <div class="lecture-icon mr-3">
                                                            @if($lecture->url)
                                                                <i class="la la-play-circle text-primary"></i>
                                                            @else
                                                                <i class="la la-file-text-o text-muted"></i>
                                                            @endif
                                                        </div>
                                                        <div class="lecture-info flex-grow-1">
                                                            <h6 class="lecture-title mb-1">{{ $lecture->lecture_title }}</h6>
                                                            @if($lecture->video_duration)
                                                                <small class="text-muted">{{ $lecture->video_duration }} menit</small>
                                                            @endif
                                                        </div>
                                                        @if($currentLecture && $currentLecture->id == $lecture->id)
                                                            <i class="la la-check-circle text-success"></i>
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 text-center">
                                <i class="la la-folder-open-o" style="font-size: 2rem; color: #ddd;"></i>
                                <p class="mt-2 text-muted">Tidak ada bagian tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">                        <a href="{{ route('user.my.courses') }}" class="btn btn-outline-secondary">
                            <i class="la la-arrow-left mr-1"></i> Kembali ke Kursus Saya
                        </a>
                        <a href="{{ route('course-details', $course->course_name_slug ?? $course->id) }}" 
                           class="btn btn-outline-primary">
                            Detail Kursus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
.course-learning-container .card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.video-container {
    position: relative;
    width: 100%;
    background: #000;
}

.lecture-item.active {
    background-color: rgba(0,123,255,0.1);
    border-left: 4px solid #007bff;
}

.lecture-link:hover {
    background-color: rgba(0,0,0,0.05);
}

.lecture-link:hover .lecture-title {
    color: #007bff !important;
}

.curriculum-section {
    border-bottom: 1px solid #eee;
}

.curriculum-section:last-child {
    border-bottom: none;
}

.section-header {
    position: sticky;
    top: 0;
    z-index: 10;
}

.lecture-content {
    max-height: 400px;
    overflow-y: auto;
}

.content-text {
    line-height: 1.6;
    color: #555;
}

@media (max-width: 991px) {
    .col-lg-8, .col-lg-4 {
        margin-bottom: 20px;
    }
}
</style>

<script>
$(document).ready(function() {
    // Auto-scroll to current lecture in sidebar
    const activeLecture = $('.lecture-item.active');
    if (activeLecture.length) {    }
    
    // Add click tracking for lectures
    $('.lecture-link').on('click', function() {
        $(this).find('.lecture-item').addClass('loading');
    });
});
</script>

<script src="{{ asset('customjs/youtube-helper.js') }}"></script>
<script src="{{ asset('customjs/user/course-learning-new.js') }}"></script>

<style>
.course-learning-container {
    margin-top: 2rem;
}

/* Video Player Styles */
.video-container-wrapper {
    background: #000;
    position: relative;
}

.video-player-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    background: #000;
}

.video-responsive {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.video-responsive iframe,
.video-responsive video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* Larger video for better viewing */
@media (min-width: 992px) {
    .video-player-container {
        padding-bottom: 56.25%; /* Keep 16:9 ratio */
        min-height: 500px; /* Minimum height for larger screens */
    }
}

@media (min-width: 1200px) {
    .video-player-container {
        min-height: 600px; /* Even larger for desktop */
    }
}

/* Lecture Navigation Styles */
.lecture-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.lecture-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.lecture-item.active {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
    font-weight: 600;
}

.lecture-item.active .lecture-icon i {
    color: #2196f3 !important;
}

.lecture-link {
    color: inherit;
    text-decoration: none;
}

.lecture-link:hover {
    color: #2196f3;
    text-decoration: none;
}

.lecture-icon {
    font-size: 1.4rem;
    width: 30px;
    text-align: center;
}

.lecture-title {
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.section-header h6 {
    font-weight: 600;
    color: #495057;
}

.lecture-content {
    background: #f8f9fa;
    border-radius: 8px;
    margin-top: 1rem;
    border-left: 4px solid #2196f3;
}

.curriculum-section {
    border-bottom: 1px solid #e9ecef;
}

.curriculum-section:last-child {
    border-bottom: none;
}

/* Loading states */
.lecture-item.loading {
    opacity: 0.6;
    pointer-events: none;
}

.lecture-item.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 15px;
    width: 20px;
    height: 20px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #2196f3;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .course-learning-container .col-lg-8,
    .course-learning-container .col-lg-4 {
        margin-bottom: 1rem;
    }
    
    .video-player-container {
        min-height: 250px;
    }
    
    .lecture-item {
        padding: 1rem !important;
    }
    
    .lecture-icon {
        font-size: 1.2rem;
    }
}

/* Better card styling */
.card-item {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
    color: white;
    border-bottom: none;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush
