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
                        <li class="breadcrumb-item active" aria-current="page">Edit Kursus</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0 text-uppercase">Edit Kursus: {{ $course->course_name }}</h6>
            <a href="{{ route('admin.course.index') }}" class="btn btn-secondary px-4">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>

        <hr />

        <form action="{{ route('admin.course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Informasi Dasar Kursus</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="course_name" class="form-label">Nama Kursus <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('course_name') is-invalid @enderror" 
                                           id="course_name" name="course_name" value="{{ old('course_name', $course->course_name) }}" 
                                           placeholder="Masukkan nama kursus">
                                    @error('course_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="course_title" class="form-label">Judul Kursus <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('course_title') is-invalid @enderror" 
                                           id="course_title" name="course_title" value="{{ old('course_title', $course->course_title) }}" 
                                           placeholder="Masukkan judul kursus">
                                    @error('course_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="subcategory_id" class="form-label">Sub Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('subcategory_id') is-invalid @enderror" 
                                            id="subcategory_id" name="subcategory_id">
                                        <option value="">Pilih Sub Kategori</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" 
                                                data-category="{{ $subcategory->category_id }}"
                                                {{ old('subcategory_id', $course->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="instructor_id" class="form-label">Instruktur <span class="text-danger">*</span></label>
                                    <select class="form-select @error('instructor_id') is-invalid @enderror" 
                                            id="instructor_id" name="instructor_id">
                                        <option value="">Pilih Instruktur</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" 
                                                {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="5" 
                                          placeholder="Masukkan deskripsi kursus">{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                            <div class="mb-3">
                                <label for="prerequisites" class="form-label">Persyaratan</label>
                                <textarea class="form-control" id="prerequisites" name="prerequisites" rows="3" 
                                          placeholder="Masukkan persyaratan kursus (opsional)">{{ old('prerequisites', $course->prerequisites) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="course_goals" class="form-label">Tujuan Pembelajaran</label>
                                <div id="goals-container">
                                    @if($course->course_goal && $course->course_goal->count() > 0)
                                        @foreach($course->course_goal as $goal)
                                        <div class="goal-item d-flex mb-2">
                                            <input type="text" class="form-control me-2" name="course_goals[]" 
                                                   value="{{ $goal->goal_name }}" placeholder="Masukkan tujuan pembelajaran">                                            <button type="button" class="btn btn-outline-danger remove-goal {{ $loop->first && $loop->count == 1 ? 'd-none' : '' }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="goal-item d-flex mb-2">
                                            <input type="text" class="form-control me-2" name="course_goals[]" 
                                                   placeholder="Contoh: Siswa akan mampu memahami konsep dasar pemrograman">
                                            <button type="button" class="btn btn-outline-danger remove-goal" style="display: none;">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-goal">
                                    <i class="bx bx-plus"></i> Tambah Tujuan
                                </button>
                                <small class="text-muted d-block mt-1">
                                    Tujuan pembelajaran membantu siswa memahami apa yang akan mereka capai setelah menyelesaikan kursus.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Kursus</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="duration" class="form-label">Durasi</label>
                                    <input type="text" class="form-control" id="duration" name="duration" 
                                           value="{{ old('duration', $course->duration) }}" placeholder="Contoh: 10 jam">
                                </div>
                                <div class="col-md-6">
                                    <label for="resources" class="form-label">Jumlah Materi</label>
                                    <input type="number" class="form-control" id="resources" name="resources" 
                                           value="{{ old('resources', $course->resources) }}" placeholder="Contoh: 25">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="selling_price" class="form-label">Harga Jual (USD) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" 
                                           id="selling_price" name="selling_price" value="{{ old('selling_price', $course->selling_price) }}" 
                                           placeholder="Contoh: 49.99">
                                    @error('selling_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_price" class="form-label">Harga Diskon (USD)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           id="discount_price" name="discount_price" value="{{ old('discount_price', $course->discount_price) }}" 
                                           placeholder="Contoh: 29.99">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="video_url" class="form-label">URL Video Intro</label>
                                    <input type="url" class="form-control" id="video_url" name="video_url" 
                                           value="{{ old('video_url', $course->video_url) }}" placeholder="https://youtube.com/watch?v=...">
                                </div>                                <div class="col-md-6">
                                    <label for="label" class="form-label">Tingkat Kesulitan</label>
                                    <select class="form-select" id="label" name="label">
                                        <option value="">Pilih Tingkat Kesulitan</option>
                                        <option value="Begginer" {{ old('label', $course->label) == 'Begginer' ? 'selected' : '' }}>Pemula</option>
                                        <option value="Middle" {{ old('label', $course->label) == 'Middle' ? 'selected' : '' }}>Menengah</option>
                                        <option value="Advance" {{ old('label', $course->label) == 'Advance' ? 'selected' : '' }}>Lanjutan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="certificate" class="form-label">Sertifikat</label>
                                    <select class="form-select" id="certificate" name="certificate">
                                        <option value="no" {{ old('certificate', $course->certificate) == 'no' ? 'selected' : '' }}>Tidak</option>
                                        <option value="yes" {{ old('certificate', $course->certificate) == 'yes' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Gambar Kursus</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="course_image" class="form-label">Upload Gambar Baru</label>
                                <input type="file" class="form-control @error('course_image') is-invalid @enderror" 
                                       id="course_image" name="course_image" accept="image/*">
                                @error('course_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</div>
                            </div>
                            
                            @if($course->course_image)
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini:</label>
                                    <div class="current-image">
                                        <img src="{{ asset('upload/course/thambnail/'.$course->course_image) }}" 
                                             alt="Current Course Image" class="img-fluid rounded">
                                    </div>
                                </div>
                            @endif
                            
                            <div id="image_preview" class="mt-3" style="display: none;">
                                <label class="form-label">Preview Gambar Baru:</label>
                                <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Pengaturan Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="bestseller" 
                                       name="bestseller" value="yes" {{ old('bestseller', $course->bestseller) == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="bestseller">Kursus Terlaris</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="featured" 
                                       name="featured" value="yes" {{ old('featured', $course->featured) == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">Kursus Unggulan</label>
                            </div>                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="highestrated" 
                                       name="highestrated" value="yes" {{ old('highestrated', $course->highestrated) == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="highestrated">Penilaian Tertinggi</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bx bx-save"></i> Perbarui Kursus
                        </button>
                        <a href="{{ route('admin.course.index') }}" class="btn btn-secondary px-4">
                            <i class="bx bx-x"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<!-- Hidden data container for subcategories and course data -->
<div id="course-edit-data" 
     data-subcategories="{{ json_encode($subcategories) }}"
     data-current-subcategory="{{ $course->subcategory_id ?? '' }}"
     style="display: none;">
</div>

<script>
$(document).ready(function() {
    // Get data from HTML data attributes
    const courseEditData = document.getElementById('course-edit-data');
    const subcategoriesData = JSON.parse(courseEditData.getAttribute('data-subcategories'));
    
    // Filter subcategories based on selected category
    $('#category_id').on('change', function() {
        var categoryId = $(this).val();
        var subcategorySelect = $('#subcategory_id');
        var currentSubcategoryId = courseEditData.getAttribute('data-current-subcategory') || null;
        
        // Reset subcategory dropdown
        subcategorySelect.html('<option value="">Pilih Sub Kategori</option>');
        
        if (categoryId) {            // Filter and add matching subcategories
            subcategoriesData.forEach(function(subcategory) {
                if (subcategory.category_id == categoryId) {
                    var selected = (subcategory.id == currentSubcategoryId) ? 'selected' : '';
                    subcategorySelect.append('<option value="' + subcategory.id + '" ' + selected + '>' + subcategory.name + '</option>');
                }
            });
        }
    });
    
    // Image preview
    $('#course_image').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_img').attr('src', e.target.result);
                $('#image_preview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#image_preview').hide();
        }
    });

    // Course Goals Management
    $('#add-goal').on('click', function() {
        var goalHtml = `
            <div class="goal-item d-flex mb-2">
                <input type="text" class="form-control me-2" name="course_goals[]" 
                       placeholder="Masukkan tujuan pembelajaran">
                <button type="button" class="btn btn-outline-danger remove-goal">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;
        $('#goals-container').append(goalHtml);
        updateRemoveButtons();
    });

    // Remove goal
    $(document).on('click', '.remove-goal', function() {
        $(this).closest('.goal-item').remove();
        updateRemoveButtons();
    });

    // Update remove buttons visibility
    function updateRemoveButtons() {
        var goalItems = $('.goal-item');
        if (goalItems.length > 1) {
            $('.remove-goal').show();
        } else {
            $('.remove-goal').hide();
        }
    }

    // Initial check for remove buttons
    updateRemoveButtons();
});
</script>
@endpush
