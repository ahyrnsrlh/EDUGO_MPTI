@extends('backend.admin.master')

@section('content')

<div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Pesanan</p>
                            <h4 class="my-1 text-info">{{ $totalOrders }}</h4>
                            <p class="mb-0 font-13">{{ $pendingOrders }} pesanan pending</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                class='bx bxs-cart'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Pendapatan</p>
                            <h4 class="my-1 text-danger">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            <p class="mb-0 font-13">Dari pesanan selesai</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                            <i class='bx bxs-wallet'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Kursus</p>
                            <h4 class="my-1 text-success">{{ $totalCourses }}</h4>
                            <p class="mb-0 font-13">{{ $activeCourses }} kursus aktif</p>
                        </div>
                        <div
                            class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                            <i class='bx bxs-book-content'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Pengguna</p>
                            <h4 class="my-1 text-warning">{{ $totalUsers }}</h4>
                            <p class="mb-0 font-13">{{ $totalInstructors }} instruktur</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                            <i class='bx bxs-group'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-12 col-lg-8 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Statistik Pesanan 7 Hari Terakhir</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown"><i
                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Lihat Detail</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Export Data</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">
                        <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                style="color: #14abef"></i>Pesanan</span>
                        <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                style="color: #ffc107"></i>Pendapatan</span>
                    </div>
                    <div class="chart-container-1">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>
                <div
                    class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                    <div class="col">
                        <div class="p-3">
                            <h5 class="mb-0">{{ $totalCategories }}</h5>
                            <small class="mb-0">Total Kategori</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3">
                            <h5 class="mb-0">{{ $activeCourses }}</h5>
                            <small class="mb-0">Kursus Aktif</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3">
                            <h5 class="mb-0">{{ number_format(($activeCourses / max($totalCourses, 1)) * 100, 1) }}%</h5>
                            <small class="mb-0">Tingkat Aktif Kursus</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Kursus Terbaru</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown"><i
                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.course.index') }}">Lihat Semua</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.course.create') }}">Tambah Kursus</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-2">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentCourses as $course)
                    <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center {{ !$loop->first ? 'border-top' : '' }}">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <img src="{{ asset($course->course_image) }}" alt="{{ $course->course_name }}" 
                                     class="rounded" width="40" height="40" style="object-fit: cover;">
                            </div>
                            <div>
                                <div class="fw-bold">{{ Str::limit($course->course_name, 20) }}</div>
                                <small class="text-muted">{{ $course->category->name ?? 'Tidak ada kategori' }}</small>
                            </div>
                        </div>
                        <span class="badge {{ $course->status == 1 ? 'bg-success' : 'bg-warning' }} rounded-pill">
                            {{ $course->status == 1 ? 'Aktif' : 'Pending' }}
                        </span>
                    </li>
                    @empty
                    <li class="list-group-item d-flex bg-transparent justify-content-center align-items-center border-top">
                        <small class="text-muted">Belum ada kursus</small>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div><!--end row-->

    <div class="card radius-10">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Pesanan Terbaru</h6>
                </div>
                <div class="dropdown ms-auto">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown"><i
                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.order.index') }}">Lihat Semua</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Export Data</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Kursus</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <img src="{{ $order->user->photo ? asset($order->user->photo) : asset('upload/no_image.jpg') }}" 
                                             alt="{{ $order->user->name }}" class="rounded-circle" width="35" height="35">
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ Str::limit($order->course_title ?? 'N/A', 30) }}</td>
                            <td>
                                @if($order->payment && $order->payment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->payment && $order->payment->status == 'complete')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($order->payment && $order->payment->status == 'cancel')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->payment ? ucfirst($order->payment->status) : 'N/A' }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($order->payment ? $order->payment->total_amount : $order->price, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <small class="text-muted">Belum ada pesanan</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Hidden data containers for JavaScript -->
<div id="dashboard-data" 
     data-order-stats="{{ json_encode($orderStats) }}"
     data-active-courses="{{ $activeCourses }}"
     data-total-courses="{{ $totalCourses }}"
     style="display: none;">
</div>

<script>
// Get data from HTML data attributes
const dashboardData = document.getElementById('dashboard-data');
const orderData = JSON.parse(dashboardData.getAttribute('data-order-stats'));
const activeCourses = parseInt(dashboardData.getAttribute('data-active-courses'));
const totalCourses = parseInt(dashboardData.getAttribute('data-total-courses'));

// Setup Chart 1 - Order Statistics
const ctx1 = document.getElementById('chart1').getContext('2d');
const chart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: orderData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
        }),
        datasets: [{
            label: 'Pesanan',
            data: orderData.map(item => item.orders),
            borderColor: '#14abef',
            backgroundColor: 'rgba(20, 171, 239, 0.1)',
            tension: 0.4
        }, {
            label: 'Pendapatan (Ribuan)',
            data: orderData.map(item => Math.round(item.revenue / 1000)),
            borderColor: '#ffc107',
            backgroundColor: 'rgba(255, 193, 7, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Setup Chart 2 - Course Status Distribution
const ctx2 = document.getElementById('chart2').getContext('2d');
const chart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Kursus Aktif', 'Kursus Pending'],
        datasets: [{
            data: [activeCourses, totalCourses - activeCourses],
            backgroundColor: ['#28a745', '#ffc107'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

@endsection
