@extends('backend.admin.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Konten Kursus</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.course.index') }}">Kelola Kursus</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Konten</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0 text-uppercase">Kelola Konten Kursus</h6>
            <div>
                <a href="{{ route('admin.course.show', $course->id) }}" class="btn btn-outline-secondary px-4 me-2">
                    <i class="bx bx-arrow-left"></i> Kembali ke Detail
                </a>
                <a href="{{ route('admin.course.index') }}" class="btn btn-secondary px-4">
                    <i class="bx bx-list-ul"></i> Daftar Kursus
                </a>
            </div>
        </div>

        <hr />

        <!-- Course Info Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $course->course_name }}</h5>
                                <p class="text-muted mb-0">{{ $course->course_title }}</p>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Instruktur: {{ $course->user->name }}</small><br>
                                <small class="text-muted">Kategori: {{ $course->category->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Section Button -->
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                    <i class="bx bx-plus"></i> Tambah Bagian Baru
                </button>
            </div>
        </div>

        <!-- Course Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Struktur Konten Kursus</h6>
                    </div>
                    <div class="card-body">
                        @if($course->sections && $course->sections->count() > 0)
                            <div id="sections-container">
                                @foreach($course->sections->sortBy('sort_order') as $section)
                                    <div class="section-item mb-4" data-section-id="{{ $section->id }}">
                                        <div class="card border-start border-primary border-3">
                                            <div class="card-header bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bx bx-menu handle me-2" style="cursor: move;"></i>
                                                        <h6 class="mb-0">
                                                            <i class="bx bx-folder text-primary me-1"></i>
                                                            {{ $section->section_title }}
                                                        </h6>
                                                        <span class="badge bg-secondary ms-2">
                                                            {{ $section->lectures->count() }} materi
                                                        </span>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-success add-lecture-btn" 
                                                                data-section-id="{{ $section->id }}">
                                                            <i class="bx bx-plus"></i> Tambah Materi
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-warning edit-section-btn" 
                                                                data-section-id="{{ $section->id }}" 
                                                                data-section-title="{{ $section->section_title }}">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-section-btn" 
                                                                data-section-id="{{ $section->id }}" 
                                                                data-section-title="{{ $section->section_title }}">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($section->lectures && $section->lectures->count() > 0)
                                                <div class="card-body">
                                                    <div class="lectures-container" data-section-id="{{ $section->id }}">
                                                        @foreach($section->lectures->sortBy('sort_order') as $lecture)
                                                            <div class="lecture-item d-flex align-items-center justify-content-between p-3 mb-2 bg-white border rounded" 
                                                                 data-lecture-id="{{ $lecture->id }}">
                                                                <div class="d-flex align-items-center flex-grow-1">
                                                                    <i class="bx bx-menu handle me-3" style="cursor: move;"></i>
                                                                    <div class="me-3">
                                                                        @if($lecture->url)
                                                                            <i class="bx bx-play-circle text-success"></i>
                                                                        @else
                                                                            <i class="bx bx-file-blank text-info"></i>
                                                                        @endif
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-1">{{ $lecture->lecture_title }}</h6>
                                                                        <small class="text-muted">
                                                                            @if($lecture->video_duration)
                                                                                Durasi: {{ $lecture->video_duration }} menit
                                                                            @endif
                                                                            @if($lecture->url)
                                                                                | <a href="{{ $lecture->url }}" target="_blank">Lihat Video</a>
                                                                            @endif
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-outline-warning edit-lecture-btn" 
                                                                            data-lecture-id="{{ $lecture->id }}"
                                                                            data-section-id="{{ $section->id }}"
                                                                            data-lecture-title="{{ $lecture->lecture_title }}"
                                                                            data-lecture-url="{{ $lecture->url }}"
                                                                            data-lecture-content="{{ $lecture->content }}"
                                                                            data-lecture-duration="{{ $lecture->video_duration }}">
                                                                        <i class="bx bx-edit"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-lecture-btn" 
                                                                            data-lecture-id="{{ $lecture->id }}"
                                                                            data-section-id="{{ $section->id }}"
                                                                            data-lecture-title="{{ $lecture->lecture_title }}">
                                                                        <i class="bx bx-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="card-body text-center py-4">
                                                    <i class="bx bx-file-blank" style="font-size: 2rem; color: #ccc;"></i>
                                                    <p class="text-muted mt-2">Belum ada materi dalam bagian ini</p>
                                                    <button type="button" class="btn btn-sm btn-primary add-lecture-btn" 
                                                            data-section-id="{{ $section->id }}">
                                                        <i class="bx bx-plus"></i> Tambah Materi Pertama
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bx bx-folder-open" style="font-size: 3rem; color: #ccc;"></i>
                                <h5 class="text-muted mt-3">Belum Ada Konten</h5>
                                <p class="text-muted">Mulai dengan menambahkan bagian pertama untuk kursus ini.</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                                    <i class="bx bx-plus"></i> Tambah Bagian Pertama
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('backend.admin.course-content.modals')

@endsection

@push('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize sortable for sections
    if (document.getElementById('sections-container')) {
        new Sortable(document.getElementById('sections-container'), {
            handle: '.section-item .handle',
            animation: 150,
            onEnd: function(evt) {
                updateSectionOrder();
            }
        });
    }

    // Initialize sortable for lectures in each section
    $('.lectures-container').each(function() {
        new Sortable(this, {
            handle: '.lecture-item .handle',
            animation: 150,
            onEnd: function(evt) {
                updateLectureOrder($(evt.to).data('section-id'));
            }
        });
    });

    // Add Section
    $('#addSectionForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("admin.course.sections.store", $course->id) }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addSectionModal').modal('hide');
                    location.reload();
                    showSuccessMessage(response.message);
                }
            },
            error: function(xhr) {
                showErrorMessage('Terjadi kesalahan saat menambahkan bagian');
            }
        });
    });

    // Edit Section
    $('.edit-section-btn').on('click', function() {
        const sectionId = $(this).data('section-id');
        const sectionTitle = $(this).data('section-title');
        
        $('#editSectionId').val(sectionId);
        $('#editSectionTitle').val(sectionTitle);
        $('#editSectionModal').modal('show');
    });

    // Update Section
    $('#editSectionForm').on('submit', function(e) {
        e.preventDefault();
        
        const sectionId = $('#editSectionId').val();
        
        $.ajax({
            url: `/admin/course/{{ $course->id }}/sections/${sectionId}`,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editSectionModal').modal('hide');
                    location.reload();
                    showSuccessMessage(response.message);
                }
            },
            error: function(xhr) {
                showErrorMessage('Terjadi kesalahan saat memperbarui bagian');
            }
        });
    });

    // Delete Section
    $('.delete-section-btn').on('click', function() {
        const sectionId = $(this).data('section-id');
        const sectionTitle = $(this).data('section-title');
        
        Swal.fire({
            title: 'Hapus Bagian?',
            text: `Bagian "${sectionTitle}" dan semua materi di dalamnya akan dihapus!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/course/{{ $course->id }}/sections/${sectionId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showSuccessMessage(response.message);
                        }
                    },
                    error: function(xhr) {
                        showErrorMessage('Terjadi kesalahan saat menghapus bagian');
                    }
                });
            }
        });
    });

    // Add Lecture
    $('.add-lecture-btn').on('click', function() {
        const sectionId = $(this).data('section-id');
        $('#addLectureSectionId').val(sectionId);
        $('#addLectureModal').modal('show');
    });

    // Submit Add Lecture
    $('#addLectureForm').on('submit', function(e) {
        e.preventDefault();
        
        const sectionId = $('#addLectureSectionId').val();
        
        $.ajax({
            url: `/admin/course/{{ $course->id }}/sections/${sectionId}/lectures`,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addLectureModal').modal('hide');
                    location.reload();
                    showSuccessMessage(response.message);
                }
            },
            error: function(xhr) {
                showErrorMessage('Terjadi kesalahan saat menambahkan materi');
            }
        });
    });

    // Edit Lecture
    $('.edit-lecture-btn').on('click', function() {
        const lectureId = $(this).data('lecture-id');
        const sectionId = $(this).data('section-id');
        const lectureTitle = $(this).data('lecture-title');
        const lectureUrl = $(this).data('lecture-url');
        const lectureContent = $(this).data('lecture-content');
        const lectureDuration = $(this).data('lecture-duration');
        
        $('#editLectureId').val(lectureId);
        $('#editLectureSectionId').val(sectionId);
        $('#editLectureTitle').val(lectureTitle);
        $('#editLectureUrl').val(lectureUrl);
        $('#editLectureContent').val(lectureContent);
        $('#editLectureDuration').val(lectureDuration);
        $('#editLectureModal').modal('show');
    });

    // Submit Edit Lecture
    $('#editLectureForm').on('submit', function(e) {
        e.preventDefault();
        
        const lectureId = $('#editLectureId').val();
        const sectionId = $('#editLectureSectionId').val();
        
        $.ajax({
            url: `/admin/course/{{ $course->id }}/sections/${sectionId}/lectures/${lectureId}`,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editLectureModal').modal('hide');
                    location.reload();
                    showSuccessMessage(response.message);
                }
            },
            error: function(xhr) {
                showErrorMessage('Terjadi kesalahan saat memperbarui materi');
            }
        });
    });

    // Delete Lecture
    $('.delete-lecture-btn').on('click', function() {
        const lectureId = $(this).data('lecture-id');
        const sectionId = $(this).data('section-id');
        const lectureTitle = $(this).data('lecture-title');
        
        Swal.fire({
            title: 'Hapus Materi?',
            text: `Materi "${lectureTitle}" akan dihapus!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/course/{{ $course->id }}/sections/${sectionId}/lectures/${lectureId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showSuccessMessage(response.message);
                        }
                    },
                    error: function(xhr) {
                        showErrorMessage('Terjadi kesalahan saat menghapus materi');
                    }
                });
            }
        });
    });

    // Helper functions
    function updateSectionOrder() {
        const sectionIds = [];
        $('#sections-container .section-item').each(function() {
            sectionIds.push($(this).data('section-id'));
        });

        $.ajax({
            url: '{{ route("admin.course.sections.reorder", $course->id) }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                section_ids: sectionIds
            },
            success: function(response) {
                if (response.success) {
                    showSuccessMessage(response.message);
                }
            }
        });
    }

    function updateLectureOrder(sectionId) {
        const lectureIds = [];
        $(`.lectures-container[data-section-id="${sectionId}"] .lecture-item`).each(function() {
            lectureIds.push($(this).data('lecture-id'));
        });

        $.ajax({
            url: `/admin/course/{{ $course->id }}/sections/${sectionId}/lectures/reorder`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                lecture_ids: lectureIds
            },
            success: function(response) {
                if (response.success) {
                    showSuccessMessage(response.message);
                }
            }
        });
    }

    function showSuccessMessage(message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function showErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message
        });
    }
});
</script>
@endpush
