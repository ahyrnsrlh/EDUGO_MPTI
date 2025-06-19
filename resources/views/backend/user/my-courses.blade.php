@extends('backend.user.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-item">            <div class="card-header">
                <h3 class="card-title fs-22">Kursus Saya</h3>
                <div class="card-header-menu">
                    <span class="badge badge-primary">{{ $enrolledCourses->count() }} Kursus</span>
                </div>
            </div><!-- end card-header -->
            <div class="card-body">
                @if($enrolledCourses->count() > 0)
                    <div class="row">
                        @foreach($enrolledCourses as $order)
                            @if($order->course)
                            <div class="col-lg-6 responsive-column-half">
                                <div class="card card-item card-preview" data-tooltip-content="#tooltip_content_{{ $order->id }}">
                                    <div class="card-image">
                                        <a href="#" class="d-block">
                                            <img class="card-img-top lazy" 
                                                 src="{{ $order->course->course_image ? asset('upload/course/thambnail/'.$order->course->course_image) : asset('frontend/images/img-loading.png') }}" 
                                                 data-src="{{ $order->course->course_image ? asset('upload/course/thambnail/'.$order->course->course_image) : asset('frontend/images/img-loading.png') }}" 
                                                 alt="{{ $order->course->course_name }}">
                                        </a>                                        <div class="course-badge-labels">
                                            <div class="course-badge">Terdaftar</div>
                                        </div>
                                    </div><!-- end card-image -->
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="#">{{ $order->course->course_name }}</a></h5>
                                        <p class="card-text"><a href="#">{{ $order->course->instructor->name ?? 'Instructor' }}</a></p>
                                        <div class="rating-wrap d-flex align-items-center py-2">
                                            <div class="review-stars">
                                                <span class="rating-number">4.4</span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star-o"></span>
                                            </div>
                                            <span class="rating-total pl-1">(20,230)</span>
                                        </div><!-- end rating-wrap -->                                        <div class="d-flex justify-content-between align-items-center">                                            <p class="card-price text-black font-weight-bold">
                                                Dibeli: Rp {{ number_format($order->amount ?? $order->price, 0, ',', '.') }}
                                            </p>
                                            <div class="course-action-wrap pl-3">
                                                <a href="#" class="btn theme-btn theme-btn-sm theme-btn-white lh-28 mr-1" data-toggle="tooltip" data-placement="top" title="Tambah ke Favorit">
                                                    <i class="la la-heart-o"></i>
                                                </a>
                                                <a href="{{ route('user.course.learn', $order->course->id) }}" class="btn theme-btn theme-btn-sm theme-btn-white lh-28" data-toggle="tooltip" data-placement="top" title="Lanjutkan Belajar">
                                                    <i class="la la-play"></i>
                                                </a>
                                            </div>
                                        </div>                                        <div class="mt-3">
                                            <small class="text-muted">
                                                Dibeli pada: {{ $order->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col-lg-6 -->
                            @endif
                        @endforeach
                    </div><!-- end row -->
                @else                    <div class="text-center py-5">
                        <div class="not-found-content">
                            <div class="icon-element mx-auto shadow-sm" data-toggle="tooltip" data-placement="top" title="Tidak Ada Kursus Ditemukan">
                                <i class="la la-book"></i>
                            </div>
                            <h4 class="mt-4 fw-500 text-gray">Tidak Ada Kursus Terdaftar</h4>
                            <p class="mt-2 text-gray">Anda belum mendaftar pada kursus apapun. Mulai belajar hari ini!</p>
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
    <!-- Script inclusion -->
    <script src="{{asset('customjs/user/my-courses.js')}}"></script>
@endpush
