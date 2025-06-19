@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course.index') }}">Kursus</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course.goals.index', $course->id) }}">Tujuan Pembelajaran</a></li>
                    <li class="breadcrumb-item active">Tambah Tujuan</li>
                </ol>
            </div>
            <h4 class="page-title">Tambah Tujuan Pembelajaran</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Tambah Tujuan Pembelajaran</h4>
                        <small class="text-muted">Untuk kursus: {{ $course->course_name }}</small>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.course.goals.index', $course->id) }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.course.goals.store', $course->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="goal_name" class="form-label">Tujuan Pembelajaran <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('goal_name') is-invalid @enderror" 
                                          id="goal_name" 
                                          name="goal_name" 
                                          rows="4" 
                                          placeholder="Contoh: Siswa akan mampu memahami konsep dasar pemrograman dan menerapkannya dalam proyek nyata"
                                          required>{{ old('goal_name') }}</textarea>
                                @error('goal_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Tuliskan tujuan pembelajaran yang spesifik dan terukur. Maksimal 500 karakter.
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card border-light bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="mdi mdi-lightbulb-outline text-warning"></i>
                                        Tips Menulis Tujuan Pembelajaran
                                    </h6>
                                    <ul class="small text-muted mb-0">
                                        <li>Gunakan kata kerja yang spesifik (memahami, menerapkan, menganalisis)</li>
                                        <li>Buat tujuan yang terukur dan dapat dicapai</li>
                                        <li>Fokus pada hasil pembelajaran siswa</li>
                                        <li>Hindari bahasa yang terlalu teknis</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.course.goals.index', $course->id) }}" class="btn btn-light">
                                    <i class="mdi mdi-close"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Simpan Tujuan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Character counter for goal_name
    const goalTextarea = $('#goal_name');
    const maxLength = 500;
    
    // Add character counter
    goalTextarea.after(`<small class="text-muted float-end"><span id="char-count">0</span>/${maxLength} karakter</small>`);
    
    // Update character counter
    goalTextarea.on('input', function() {
        const currentLength = $(this).val().length;
        $('#char-count').text(currentLength);
        
        if (currentLength > maxLength * 0.9) {
            $('#char-count').addClass('text-warning');
        } else {
            $('#char-count').removeClass('text-warning');
        }
        
        if (currentLength > maxLength) {
            $('#char-count').addClass('text-danger').removeClass('text-warning');
        } else {
            $('#char-count').removeClass('text-danger');
        }
    });
    
    // Trigger initial count
    goalTextarea.trigger('input');
});
</script>
@endpush
