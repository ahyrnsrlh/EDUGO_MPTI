@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course.index') }}">Kursus</a></li>
                    <li class="breadcrumb-item active">Tujuan Pembelajaran</li>
                </ol>
            </div>
            <h4 class="page-title">Kelola Tujuan Pembelajaran</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">
                            Tujuan Pembelajaran - {{ $course->course_name }}
                        </h4>
                        <small class="text-muted">Kelola tujuan pembelajaran untuk kursus ini</small>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group">
                            <a href="{{ route('admin.course.show', $course->id) }}" class="btn btn-outline-secondary">
                                <i class="mdi mdi-arrow-left"></i> Kembali ke Detail Kursus
                            </a>
                            <a href="{{ route('admin.course.goals.create', $course->id) }}" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Tambah Tujuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($goals->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="75%">Tujuan Pembelajaran</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($goals as $key => $goal)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <i class="mdi mdi-target text-primary me-2 mt-1"></i>
                                            <span>{{ $goal->goal_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $goal->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.course.goals.edit', [$course->id, $goal->id]) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger delete-goal" 
                                                    data-goal-id="{{ $goal->id }}"
                                                    data-course-id="{{ $course->id }}"
                                                    title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="mdi mdi-target-account" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                        <h5 class="text-muted">Belum Ada Tujuan Pembelajaran</h5>
                        <p class="text-muted mb-3">Tambahkan tujuan pembelajaran untuk kursus ini agar siswa mengetahui apa yang akan mereka pelajari.</p>
                        <a href="{{ route('admin.course.goals.create', $course->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Tambah Tujuan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Delete goal functionality
    $('.delete-goal').on('click', function() {
        let goalId = $(this).data('goal-id');
        let courseId = $(this).data('course-id');
        let row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Hapus Tujuan Pembelajaran?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/course/${courseId}/goals/${goalId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.fadeOut(300, function() {
                                $(this).remove();
                                
                                // Check if table is empty
                                if ($('tbody tr').length === 0) {
                                    location.reload();
                                }
                            });
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat menghapus data!'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
