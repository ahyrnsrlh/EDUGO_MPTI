@extends('backend.admin.master')

<style>
    .form-check-input {
        width: 2.5rem;
        height: 1.5rem;
        transform: scale(1.3);
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
        background-col                    }
                });
            }
            
            // Initialize the DataTable
            const table = initializeDataTable();

            // Custom filtersf8f9fa;
        tran                }
            });
            
            // Export functionality
            $('#exportBtn').on('click', function() {
                Swal.fire({
                    title: 'Export Data Kursus',
                    text: 'Pilih format export yang diinginkan:',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bx bx-file-blank"></i> Export CSV',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Simple CSV export using current table data
                        let csvContent = "data:text/csv;charset=utf-8,";
                        csvContent += "No,Nama Kursus,Instruktur,Kategori,Harga,Status\n";
                        
                        table.rows().every(function() {
                            const data = this.data();
                            const row = [
                                $(data[0]).text(),
                                $(data[2]).find('strong').text(),
                                $(data[3]).text(),
                                $(data[4]).text(),
                                $(data[5]).text().replace(/\n/g, ' '),
                                $(data[6]).find('small').text()
                            ];
                            csvContent += row.join(",") + "\n";
                        });
                        
                        const encodedUri = encodeURI(csvContent);
                        const link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "daftar_kursus_" + new Date().toISOString().slice(0,10) + ".csv");
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data berhasil diexport!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            // Delete course functionalitym: translateX(2px);
        transition: all 0.2s ease-in-out;
    }
    
    .dropdown-header {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .action-btn {
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
    }
    
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .course-image {
        border-radius: 8px;
        transition: transform 0.2s ease-in-out;
    }
    
    .course-image:hover {
        transform: scale(1.05);
    }
    
    .status-switch {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    
    .badge-count {
        font-size: 0.65rem;
        padding: 0.25rem 0.4rem;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .dropdown-menu {
            min-width: 200px;
        }
        
        .course-image {
            width: 60px !important;
            height: 45px !important;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
    
    /* Print styles */
    @media print {
        .dropdown, .action-btn {
            display: none !important;
        }
    }
</style>

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Kursus</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Semua Kursus</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div style="display: flex; align-items:center; justify-content:space-between">
            <h6 class="mb-0 text-uppercase">Semua Kursus</h6>
            <a href="{{ route('admin.course.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Kursus
            </a>
        </div>

        <hr />
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-start border-primary border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $all_courses->count() }}</h5>
                                <p class="text-muted mb-0">Total Kursus</p>
                            </div>
                            <div class="widgets-icons bg-primary text-white">
                                <i class="bx bx-book-content"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-start border-success border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $all_courses->where('status', 1)->count() }}</h5>
                                <p class="text-muted mb-0">Kursus Aktif</p>
                            </div>
                            <div class="widgets-icons bg-success text-white">
                                <i class="bx bx-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-start border-warning border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $all_courses->where('status', 0)->count() }}</h5>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                            <div class="widgets-icons bg-warning text-white">
                                <i class="bx bx-time"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-start border-info border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $all_courses->where('featured', 'yes')->count() }}</h5>
                                <p class="text-muted mb-0">Unggulan</p>
                            </div>
                            <div class="widgets-icons bg-info text-white">
                                <i class="bx bx-crown"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Daftar Kursus</h6>
                    <div class="d-flex gap-2 align-items-center">
                        <!-- Quick Actions -->
                        <div class="btn-group" role="group" aria-label="Quick actions">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.location.reload()" 
                                    data-bs-toggle="tooltip" title="Refresh data">
                                <i class="bx bx-refresh"></i>
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" id="exportBtn"
                                    data-bs-toggle="tooltip" title="Export data">
                                <i class="bx bx-download"></i>
                            </button>
                        </div>
                        
                        <!-- Filters -->
                        <select class="form-select form-select-sm" id="statusFilter" style="width: auto;">
                            <option value="">Semua Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Pending</option>
                        </select>
                        <select class="form-select form-select-sm" id="categoryFilter" style="width: auto;">
                            <option value="">Semua Kategori</option>
                            @php $categories = $all_courses->pluck('category.name')->unique(); @endphp
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Kursus</th>
                                <th>Instruktur</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_courses as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($item->course_image)
                                            <img src="{{ asset($item->course_image) }}" width="80" height="60" 
                                                 class="course-image" style="object-fit: cover;" />
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light course-image" 
                                                 style="width: 80px; height: 60px;">
                                                <i class="bx bx-image text-muted fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-truncate d-block" style="max-width: 200px;">{{ $item->course_name }}</strong>
                                            <small class="text-muted d-block text-truncate" style="max-width: 200px;">{{ $item->course_title }}</small>
                                            <div class="mt-1">
                                                @if($item->bestseller == 'yes')
                                                    <span class="badge bg-warning text-dark">Terlaris</span>
                                                @endif
                                                @if($item->featured == 'yes')
                                                    <span class="badge bg-primary">Unggulan</span>
                                                @endif
                                                @if($item->highestrated == 'yes')
                                                    <span class="badge bg-success">Rating Tinggi</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>
                                        @if($item->discount_price)
                                        <span class="text-success fw-bold">Rp {{ number_format($item->discount_price * 15000, 0, ',', '.') }}</span>
                                        <br>
                                        <small class="text-decoration-line-through text-muted">Rp {{ number_format($item->selling_price * 15000, 0, ',', '.') }}</small>
                                        @else
                                        <span class="fw-bold">Rp {{ number_format($item->selling_price * 15000, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-switch" >
                                            <input class="form-check-input" style="cursor: pointer" type="checkbox" role="switch"
                                                id="flexSwitchCheckDefault{{ $item->id }}"
                                                data-course-id="{{ $item->id }}"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Klik untuk mengubah status kursus"
                                                {{ $item->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault{{ $item->id }}">
                                                <small>{{ $item->status == 1 ? 'Aktif' : 'Pending' }}</small>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                    id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" 
                                                    aria-expanded="false" aria-label="Menu aksi untuk {{ $item->course_name }}">
                                                <i class="bx bx-dots-horizontal-rounded"></i> Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                <li>
                                                    <h6 class="dropdown-header">
                                                        <i class="bx bx-book me-1"></i>Kelola Kursus
                                                    </h6>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.course.show', $item->id) }}">
                                                        <i class="bx bx-show me-2 text-info"></i>Lihat Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.course.edit', $item->id) }}">
                                                        <i class="bx bx-edit me-2 text-warning"></i>Edit Kursus
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <h6 class="dropdown-header">
                                                        <i class="bx bx-cog me-1"></i>Kelola Konten
                                                    </h6>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.course.content.index', $item->id) }}">
                                                        <i class="bx bx-book-content me-2 text-success"></i>Kelola Konten
                                                        @php
                                                            $contentCount = $item->sections ? $item->sections->sum(function($s) { return $s->lectures->count(); }) : 0;
                                                        @endphp
                                                        @if($contentCount > 0)
                                                            <span class="badge bg-success ms-1">{{ $contentCount }}</span>
                                                        @endif
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.course.goals.index', $item->id) }}">
                                                        <i class="bx bx-list-ul me-2 text-primary"></i>Kelola Tujuan
                                                        @php
                                                            $goalsCount = $item->course_goal ? $item->course_goal->count() : 0;
                                                        @endphp
                                                        @if($goalsCount > 0)
                                                            <span class="badge bg-primary ms-1">{{ $goalsCount }}</span>
                                                        @endif
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger delete-btn" 
                                                            data-course-id="{{ $item->id }}" 
                                                            data-course-name="{{ $item->course_name }}">
                                                        <i class="bx bx-trash me-2"></i>Hapus Kursus
                                                    </button>
                                                </li>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Function to initialize DataTable
            function initializeDataTable() {
                // Check if DataTable is already initialized and destroy it
                if ($.fn.DataTable.isDataTable('#example')) {
                    $('#example').DataTable().destroy();
                }
                
                return $('#example').DataTable({
                    "responsive": true,
                    "pageLength": 10,
                    "lengthMenu": [5, 10, 25, 50],
                    "order": [[0, "asc"]],
                    "columnDefs": [
                        { "orderable": false, "targets": [-1] }, // Disable sorting on action column
                        { "width": "5%", "targets": 0 }, // No column
                        { "width": "10%", "targets": 1 }, // Image
                        { "width": "25%", "targets": 2 }, // Course name
                        { "width": "15%", "targets": 3 }, // Instructor
                        { "width": "15%", "targets": 4 }, // Category
                        { "width": "15%", "targets": 5 }, // Price
                        { "width": "10%", "targets": 6 }, // Status
                        { "width": "10%", "targets": 7 }  // Actions
                    ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }                });
            }
            
            // Initialize the DataTable
            const table = initializeDataTable();

            // Custom filters
            $('#statusFilter').off('change').on('change', function() {
                const status = $(this).val();
                if (status === '') {
                    table.column(6).search('').draw();
                } else {
                    const statusText = status === '1' ? 'Aktif' : 'Pending';
                    table.column(6).search(statusText).draw();
                }
            });

            $('#categoryFilter').off('change').on('change', function() {
                const category = $(this).val();
                table.column(4).search(category).draw();
            });

            // Status toggle functionality
            $('.form-check-input').off('change').on('change', function() {
                const courseId = $(this).data('course-id');
                const status = $(this).is(':checked') ? 1 : 0;
                const row = $(this).closest('tr');
                const switchElement = $(this);
                
                // Disable switch during request
                switchElement.prop('disabled', true);

                $.ajax({
                    url: '{{ route('admin.course.status') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: courseId,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the label text
                            const label = switchElement.next('label').find('small');
                            label.text(status === 1 ? 'Aktif' : 'Pending');

                            // Show SweetAlert Toast Notification
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            // Revert the switch state
                            switchElement.prop('checked', !status);
                            
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Error: ' + response.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Revert the switch state
                        switchElement.prop('checked', !status);
                        
                        console.error('AJAX Error:', error);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Terjadi kesalahan saat memperbarui status.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    complete: function() {
                        // Re-enable switch
                        switchElement.prop('disabled', false);
                    }
                });
            });

            // Delete course functionality
            $('.delete-btn').off('click').on('click', function() {
                const courseId = $(this).data('course-id');
                const courseName = $(this).data('course-name');
                const row = $(this).closest('tr');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus kursus "${courseName}"? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url("admin/course") }}/' + courseId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove the row from DataTable
                                    table.row(row).remove().draw();

                                    // Show success message
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                } else {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Error: ' + response.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', error);
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Terjadi kesalahan saat menghapus kursus.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            });
            
            // Cleanup function when page is unloaded
            $(window).on('beforeunload', function() {
                if ($.fn.DataTable.isDataTable('#example')) {
                    $('#example').DataTable().destroy();
                }
            });
        });
    </script>
@endpush
