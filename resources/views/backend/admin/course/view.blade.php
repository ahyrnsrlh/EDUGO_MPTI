@extends('backend.admin.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Kursus</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.course.index') }}">Kelola Kursus</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Kursus</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0 text-uppercase">Detail Kursus</h6>
            <div>
                <a href="{{ route('admin.course.content.index', $course->id) }}" class="btn btn-success px-4 me-2">
                    <i class="bx bx-book-content"></i> Kelola Konten
                </a>
                <a href="{{ route('admin.course.goals.index', $course->id) }}" class="btn btn-info px-4 me-2">
                    <i class="bx bx-list-ul"></i> Kelola Tujuan
                </a>
                <a href="{{ route('admin.course.edit', $course->id) }}" class="btn btn-warning px-4 me-2">
                    <i class="bx bx-edit"></i> Edit
                </a>
                <a href="{{ route('admin.course.index') }}" class="btn btn-secondary px-4">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>

        <hr />

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Informasi Kursus</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Nama Kursus</h6>
                                    <span class="text-muted">{{ $course->course_name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Judul Kursus</h6>
                                    <span class="text-muted">{{ $course->course_title }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Kategori</h6>
                                    <span class="text-muted">{{ $course->category->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Sub Kategori</h6>
                                    <span class="text-muted">{{ $course->subCategory->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Instruktur</h6>
                                    <span class="text-muted">{{ $course->user->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Status</h6>
                                    @if($course->status == 0)
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @else
                                        <span class="badge bg-success">Aktif</span>
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Harga Jual</h6>
                                    <span class="text-success fw-bold fs-5">Rp {{ number_format($course->selling_price * 15000, 0, ',', '.') }}</span>
                                </div>
                            </li>
                            @if($course->discount_price)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Harga Diskon</h6>
                                    <span class="text-danger fw-bold fs-5">Rp {{ number_format($course->discount_price * 15000, 0, ',', '.') }}</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Detail & Media</h6>
                    </div>
                    <div class="card-body">
                        @if($course->course_image)
                        <div class="mb-3">
                            <h6>Gambar Kursus</h6>
                            <img src="{{ asset('upload/course/thambnail/'.$course->course_image) }}" 
                                 alt="{{ $course->course_name }}" class="img-fluid rounded">
                        </div>
                        @endif
                        
                        @if(!empty($course->video_url))
                        <div class="mb-3">
                            <h6>Video Intro</h6>
                            @if(str_contains($course->video_url, 'youtube.com') || str_contains($course->video_url, 'youtu.be'))
                                @php
                                    $video_id = '';
                                    if (str_contains($course->video_url, 'youtube.com/watch?v=')) {
                                        $video_id = substr($course->video_url, strpos($course->video_url, 'v=') + 2);
                                    } elseif (str_contains($course->video_url, 'youtu.be/')) {
                                        $video_id = substr($course->video_url, strpos($course->video_url, 'youtu.be/') + 9);
                                    }
                                    if (str_contains($video_id, '&')) {
                                        $video_id = substr($video_id, 0, strpos($video_id, '&'));
                                    }
                                @endphp
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/{{ $video_id }}" 
                                            title="Video Intro" allowfullscreen></iframe>
                                </div>
                            @else
                                <a href="{{ $course->video_url }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bx bx-play"></i> Lihat Video
                                </a>
                            @endif
                        </div>
                        @endif
                        
                        <ul class="list-group list-group-flush">
                            @if($course->duration)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Durasi</h6>
                                <span class="badge bg-primary rounded-pill">{{ $course->duration }}</span>
                            </li>
                            @endif
                            @if($course->resources)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Jumlah Materi</h6>
                                <span class="badge bg-info rounded-pill">{{ $course->resources }}</span>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Sertifikat</h6>
                                @if($course->certificate == 'yes')
                                    <span class="badge bg-success rounded-pill">Ya</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Tidak</span>
                                @endif
                            </li>
                            @if($course->label)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Tingkat Kesulitan</h6>
                                <span class="badge bg-warning rounded-pill">
                                    @if($course->label == 'Begginer') Pemula
                                    @elseif($course->label == 'Middle') Menengah
                                    @elseif($course->label == 'Advance') Lanjutan
                                    @else {{ $course->label }}
                                    @endif
                                </span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>                        @if($course->description || $course->prerequisites)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Deskripsi & Persyaratan</h6>
                    </div>
                    <div class="card-body">
                        @if($course->description)
                        <div class="mb-4">
                            <h6>Deskripsi Kursus</h6>
                            <p class="text-muted">{{ $course->description }}</p>
                        </div>
                        @endif
                        
                        @if($course->prerequisites)
                        <div>
                            <h6>Persyaratan</h6>
                            <p class="text-muted">{{ $course->prerequisites }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif                        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Tujuan Pembelajaran</h6>
                        <a href="{{ route('admin.course.goals.index', $course->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-cog"></i> Kelola Tujuan
                        </a>
                    </div>
                    <div class="card-body">
                        @if($course->course_goal && $course->course_goal->count() > 0)
                            <div class="row">
                                @foreach($course->course_goal as $goal)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-check-circle text-success me-2 mt-1"></i>
                                        <span class="text-muted">{{ $goal->goal_name }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bx bx-target" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Belum ada tujuan pembelajaran yang ditambahkan.</p>
                                <a href="{{ route('admin.course.goals.create', $course->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus"></i> Tambah Tujuan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Pengaturan Khusus</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    @if($course->bestseller == 'yes')
                                        <i class="bx bx-star text-warning me-2"></i>
                                        <span class="text-warning">Kursus Terlaris</span>
                                    @else
                                        <i class="bx bx-star text-muted me-2"></i>
                                        <span class="text-muted">Bukan Kursus Terlaris</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    @if($course->featured == 'yes')
                                        <i class="bx bx-crown text-primary me-2"></i>
                                        <span class="text-primary">Kursus Unggulan</span>
                                    @else
                                        <i class="bx bx-crown text-muted me-2"></i>
                                        <span class="text-muted">Bukan Kursus Unggulan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    @if($course->highestrated == 'yes')
                                        <i class="bx bx-like text-success me-2"></i>
                                        <span class="text-success">Penilaian Tertinggi</span>
                                    @else
                                        <i class="bx bx-like text-muted me-2"></i>
                                        <span class="text-muted">Bukan Penilaian Tertinggi</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Konten Kursus</h6>
                        <a href="{{ route('admin.course.content.index', $course->id) }}" class="btn btn-sm btn-outline-success">
                            <i class="bx bx-cog"></i> Kelola Konten
                        </a>
                    </div>
                    <div class="card-body">
                        @if($course->sections && $course->sections->count() > 0)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-primary">{{ $course->sections->count() }}</h4>
                                        <small class="text-muted">Bagian</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-success">{{ $course->sections->sum(function($section) { return $section->lectures->count(); }) }}</h4>
                                        <small class="text-muted">Total Materi</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-info">{{ $course->sections->sum(function($section) { return $section->lectures->sum('video_duration'); }) }}</h4>
                                        <small class="text-muted">Menit Video</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-warning">{{ $course->sections->sum(function($section) { return $section->lectures->where('url', '!=', '')->count(); }) }}</h4>
                                        <small class="text-muted">Video Tersedia</small>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="mb-3">
                                <h6>Ringkasan Konten:</h6>
                                @foreach($course->sections->take(3) as $section)
                                <div class="mb-2">
                                    <strong>{{ $section->section_title }}</strong>
                                    <span class="badge bg-light text-dark ms-2">{{ $section->lectures->count() }} materi</span>
                                </div>
                                @endforeach
                                @if($course->sections->count() > 3)
                                <div class="text-muted">
                                    ... dan {{ $course->sections->count() - 3 }} bagian lainnya
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bx bx-book-content" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Belum ada konten yang ditambahkan.</p>
                                <a href="{{ route('admin.course.content.index', $course->id) }}" class="btn btn-sm btn-success">
                                    <i class="bx bx-plus"></i> Mulai Tambah Konten
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
