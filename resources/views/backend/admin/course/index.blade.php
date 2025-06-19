@extends('backend.admin.master')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tabel</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Kursus</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title">Daftar Kursus</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm" id="exportBtn">
                                <i class="bx bx-export"></i> Export
                            </button>
                            <a href="{{ route('admin.course.create') }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-plus"></i> Tambah Kursus
                            </a>
                        </div>
                    </div>

                    <!-- Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="instructorFilter">
                                <option value="">Semua Instruktur</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->name }}">{{ $instructor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="coursesTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Gambar</th>
                                    <th width="25%">Nama Kursus</th>
                                    <th width="15%">Instruktur</th>
                                    <th width="12%">Kategori</th>
                                    <th width="12%">Harga</th>
                                    <th width="10%">Status</th>
                                    <th width="11%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $key => $course)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset('upload/course/thambnail/'.$course->course_image) }}" 
                                                 alt="{{ $course->course_name }}" 
                                                 class="img-fluid rounded" 
                                                 style="width: 60px; height: 40px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <strong>{{ $course->course_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($course->course_title, 50) }}</small>
                                        </td>
                                        <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                                        <td>{{ $course->category->category_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($course->discount_price)
                                                <span class="text-decoration-line-through text-muted">Rp {{ number_format($course->selling_price, 0, ',', '.') }}</span>
                                                <br>
                                                <strong class="text-success">Rp {{ number_format($course->discount_price, 0, ',', '.') }}</strong>
                                            @else
                                                <strong>Rp {{ number_format($course->selling_price, 0, ',', '.') }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if($course->status == 1)
                                                <span class="badge bg-success">
                                                    <i class="bx bx-check-circle"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bx bx-x-circle"></i> Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $course->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $course->id }}">
                                                    <li><a class="dropdown-item" href="{{ route('admin.course.details', $course->id) }}">
                                                        <i class="bx bx-show"></i> Lihat Detail
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('admin.course.edit', $course->id) }}">
                                                        <i class="bx bx-edit"></i> Edit
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>                                                    <li><a class="dropdown-item text-danger delete-course-btn" href="javascript:void(0)" 
                                                           data-course-id="{{ $course->id }}"
                                                           data-course-name="{{ $course->course_name }}">
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#coursesTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        },
        columnDefs: [
            { orderable: false, targets: [1, 7] }
        ]
    });

    // Filter functionality
    $('#categoryFilter').on('change', function() {
        table.column(4).search(this.value).draw();
    });

    $('#statusFilter').on('change', function() {
        const status = this.value;
        if (status === '') {
            table.column(6).search('').draw();
        } else if (status === '1') {
            table.column(6).search('Aktif').draw();
        } else {
            table.column(6).search('Tidak Aktif').draw();
        }
    });

    $('#instructorFilter').on('change', function() {
        table.column(3).search(this.value).draw();
    });    // Delete course functionality
    $(document).on('click', '.delete-course-btn', function(e) {
        e.preventDefault();
        const courseId = $(this).data('course-id');
        const courseName = $(this).data('course-name');
        deleteCourse(courseId, courseName);
    });
});

function deleteCourse(id, courseName) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Data kursus "${courseName}" akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/course/${id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', response.message || 'Kursus telah dihapus.', 'success');
                        location.reload();
                    } else {
                        Swal.fire('Error!', response.message || 'Gagal menghapus kursus.', 'error');
                    }
                },
                error: function(xhr) {
                    let message = 'Gagal menghapus kursus.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire('Error!', message, 'error');
                }
            });
        }
    });
}
</script>

<style>
.table img {
    border-radius: 8px;
}

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: 0;
    border-radius: 0.375rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    margin: 0.125rem;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
    transition: all 0.2s ease-in-out;
}

.badge {
    font-size: 0.75rem;
}

.btn-sm {
    font-size: 0.8rem;
}
</style>
@endpush
