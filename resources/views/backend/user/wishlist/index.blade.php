@extends('backend.user.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-item">
            <div class="card-header">
                <h3 class="card-title fs-22">Kursus Favorit Saya</h3>
                <div class="card-header-menu">
                    <span class="badge badge-primary">{{ $wishlist->total() }} Kursus</span>
                </div>
            </div><!-- end card-header -->
            <div class="card-body">
                @if($wishlist->count() > 0)
                    <div class="row" id="wishlist-container">
                        @foreach($wishlist as $item)
                            <div class="col-lg-6 responsive-column-half">
                                <div class="card card-item card-preview wishlist-item" data-wishlist-id="{{ $item->id }}">
                                    <div class="card-image">
                                        <a href="{{ route('course-details', $item->course->course_name_slug ?? '#') }}" class="d-block">
                                            <img class="card-img-top lazy" 
                                                 src="{{ asset($item->course->course_image) }}" 
                                                 alt="{{ $item->course->course_name }}">
                                        </a>
                                        <div class="course-badge-labels">
                                            <div class="course-badge">Favorit</div>
                                        </div>
                                        <div class="card-action">
                                            <button class="btn btn-danger btn-sm remove-wishlist" data-id="{{ $item->id }}" title="Hapus dari Favorit">
                                                <i class="la la-times"></i>
                                            </button>
                                        </div>
                                    </div><!-- end card-image -->
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('course-details', $item->course->course_name_slug ?? '#') }}">
                                                {{ $item->course->course_name }}
                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            <a href="#">{{ $item->course->instructor->name ?? 'Instructor' }}</a>
                                        </p>
                                        <div class="rating-wrap d-flex align-items-center py-2">
                                            <div class="review-stars">
                                                <span class="rating-number">4.4</span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star-o"></span>
                                            </div>
                                            <span class="rating-total pl-1">({{ rand(100, 999) }})</span>
                                        </div><!-- end rating-wrap -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="card-price text-black font-weight-bold">
                                                @if($item->course->discount_price)
                                                    Rp {{ number_format($item->course->selling_price, 0, ',', '.') }}
                                                    <span class="before-price fs-14">Rp {{ number_format($item->course->discount_price, 0, ',', '.') }}</span>
                                                @else
                                                    Rp {{ number_format($item->course->selling_price ?? 0, 0, ',', '.') }}
                                                @endif
                                            </p>
                                            <div class="course-action-wrap pl-3">
                                                <button class="btn theme-btn theme-btn-sm add-to-cart" 
                                                        data-course-id="{{ $item->course->id }}" 
                                                        data-toggle="tooltip" 
                                                        data-placement="top" 
                                                        title="Tambah ke Keranjang">
                                                    <i class="la la-shopping-cart mr-1"></i> Tambah ke Keranjang
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                Ditambahkan ke favorit: {{ $item->created_at->format('d M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                {{ $item->course->course_description ? Str::limit($item->course->course_description, 80) : 'Tidak ada deskripsi tersedia' }}
                                            </small>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col-lg-6 -->
                        @endforeach
                    </div><!-- end row -->

                    <!-- Pagination -->
                    @if($wishlist->hasPages())
                        <div class="text-center py-3">
                            <nav aria-label="Page navigation example" class="pagination-box">
                                {{ $wishlist->links() }}
                            </nav>
                        </div>
                    @endif

                @else
                    <div class="text-center py-5">
                        <div class="not-found-content">
                            <div class="icon-element mx-auto shadow-sm" data-toggle="tooltip" data-placement="top" title="Tidak Ada Kursus Ditemukan">
                                <i class="la la-heart-o"></i>
                            </div>
                            <h4 class="mt-4 fw-500 text-gray">Daftar Favorit Kosong</h4>
                            <p class="mt-2 text-gray">Jelajahi kursus dan tambahkan ke favorit untuk melacak apa yang ingin Anda pelajari!</p>
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
    <script src="{{asset('customjs/user/wishlist.js')}}"></script>
    <style>
        .wishlist-item .card-action {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
        }
        .wishlist-item .card-action .btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>
@endpush


