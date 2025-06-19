@extends('backend.user.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-item">            <div class="card-header">
                <h3 class="card-title fs-22">Riwayat Pembelian</h3>
                <div class="card-header-menu">
                    <span class="badge badge-primary">{{ $orders->total() }} Pesanan</span>
                </div>
            </div><!-- end card-header -->
            <div class="card-body">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">                            <thead>
                                <tr>
                                    <th>Tanggal Pesanan</th>
                                    <th>Kursus</th>
                                    <th>Instruktur</th>
                                    <th>Jumlah</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $order->created_at->format('d M Y') }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($order->course)
                                                    <img src="{{ asset($order->course->course_image) }}" 
                                                         alt="{{ $order->course->course_name }}" 
                                                         class="mr-3 rounded" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0">{{ $order->course->course_name }}</h6>
                                                        <small class="text-muted">{{ Str::limit($order->course->course_description ?? 'Tidak ada deskripsi', 50) }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">{{ $order->course_title ?? 'Kursus tidak ditemukan' }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($order->course && $order->course->instructor)
                                                {{ $order->course->instructor->name }}
                                            @else
                                                <span class="text-muted">Tidak Diketahui</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                Rp {{ number_format($order->amount ?? $order->price ?? 0, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td>
                                            @if($order->payment)
                                                <div>
                                                    <span class="badge badge-info">{{ $order->payment->payment_type ?? 'Tidak Diketahui' }}</span>
                                                    @if($order->payment->transaction_id)
                                                        <br>
                                                        <small class="text-muted">{{ $order->payment->transaction_id }}</small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>                            @switch($order->status)
                                                @case('completed')
                                                    <span class="badge badge-success">Selesai</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                    @break
                                                @case('failed')
                                                    <span class="badge badge-danger">Gagal</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">{{ ucfirst($order->status ?? 'Tidak Diketahui') }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if($order->course && $order->status === 'completed')
                                                    <a href="{{ route('course-details', $order->course->course_name_slug ?? '#') }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Lihat Kursus">
                                                        <i class="la la-eye"></i>
                                                    </a>
                                                @endif
                                                @if($order->payment && $order->payment->invoice_no)
                                                    <button class="btn btn-sm btn-outline-secondary" 
                                                            title="Invoice: {{ $order->payment->invoice_no }}"
                                                            onclick="alert('Invoice: {{ $order->payment->invoice_no }}')">
                                                        <i class="la la-file-text"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="text-center py-3">
                            <nav aria-label="Page navigation example" class="pagination-box">
                                {{ $orders->links() }}
                            </nav>
                        </div>
                    @endif

                    <!-- Summary Stats -->
                    <div class="row mt-4">                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h5>Total Pesanan</h5>
                                <h3 class="text-primary">{{ $orders->total() }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h5>Total Belanja</h5>
                                <h3 class="text-success">
                                    Rp {{ number_format($orders->sum(function($order) { return $order->amount ?? $order->price ?? 0; }), 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h5>Pesanan Selesai</h5>
                                <h3 class="text-info">{{ $orders->where('status', 'completed')->count() }}</h3>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">                        <div class="not-found-content">
                            <div class="icon-element mx-auto shadow-sm" data-toggle="tooltip" data-placement="top" title="Tidak Ada Pesanan">
                                <i class="la la-shopping-cart"></i>
                            </div>
                            <h4 class="mt-4 fw-500 text-gray">Tidak Ada Riwayat Pembelian</h4>
                            <p class="mt-2 text-gray">Anda belum melakukan pembelian apapun. Mulai jelajahi kursus untuk melakukan pembelian pertama!</p>
                            <a href="{{ route('frontend.home') }}" class="btn theme-btn mt-4">Jelajahi Kursus</a>
                        </div>
                    </div>
                @endif
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col-lg-12 -->
</div><!-- end row -->

@endsection

@push('scripts')
    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            color: #555;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,123,255,.075);
        }
    </style>
@endpush
