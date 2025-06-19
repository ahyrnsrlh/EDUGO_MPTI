@extends('frontend.master')

@push('styles')
<style>
.category-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.category-img:hover,
.category-icon-placeholder:hover {
    transform: scale(1.05);
    border-color: #007bff !important;
}

.category-icon-placeholder {
    cursor: pointer;
}

.category-icon-placeholder:hover {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.generic-list-item li {
    border-bottom: 1px solid #f5f5f5;
    transition: background-color 0.3s ease;
}

.generic-list-item li:hover {
    background-color: #f8f9fa;
    border-radius: 6px;
}

.generic-list-item li:last-child {
    border-bottom: none;
}

.badge-light {
    background-color: #e9ecef;
    color: #495057;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 12px;
}

.category-name {
    color: #333;
    transition: color 0.3s ease;
}

.generic-list-item li:hover .category-name {
    color: #007bff;
}
</style>
@endpush

@section('content')
<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area section-padding img-bg-2">
    <div class="overlay"></div>
    <div class="container">        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">            <div class="section-heading">
                <h2 class="section__title text-white">
                    @if(isset($currentCategory))
                        Kursus {{ $currentCategory->name }}
                    @else
                        Semua Kursus
                    @endif
                </h2>
            </div>
            <ul class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                @if(isset($currentCategory))
                    <li><a href="{{ route('all.courses') }}">Semua Kursus</a></li>
                    <li>{{ $currentCategory->name }}</li>
                @else
                    <li>Semua Kursus</li>
                @endif
            </ul>
        </div><!-- end breadcrumb-content -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
       START COURSE AREA
================================= -->
<section class="course-area section--padding">
    <div class="container">
        <div class="filter-bar mb-4">
            <div class="filter-bar-inner d-flex flex-wrap align-items-center justify-content-between">
                <p class="fs-14">Menampilkan {{ $all_courses->count() }} dari {{ $all_courses->total() }} kursus</p>
                <div class="filter-option-box w-20">
                    <select class="select-container">
                        <option value="newest" selected>Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="popular">Terpopuler</option>
                        <option value="price-low">Harga Terendah</option>
                        <option value="price-high">Harga Tertinggi</option>
                    </select>
                </div><!-- end filter-option-box -->
            </div><!-- end filter-bar-inner -->
        </div><!-- end filter-bar -->
        
        <div class="row">
            <div class="col-lg-3">
                <div class="sidebar mb-5">
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="card-title fs-18 pb-2">Kategori</h3>                            <div class="divider"><span></span></div>
                            <ul class="generic-list-item">
                                @foreach($categories as $category)                                <li class="py-2">
                                    <a href="{{ route('courses.by.category', $category->slug) }}" class="d-flex align-items-center justify-content-between text-decoration-none @if(isset($currentCategory) && $currentCategory->id == $category->id) text-primary font-weight-bold @endif"><div class="d-flex align-items-center">
                                            <div class="category-img-wrapper mr-3">
                                                @if($category->category_image && file_exists(public_path($category->category_image)))
                                                    <img src="{{ asset($category->category_image) }}" 
                                                         alt="{{ $category->name }}" 
                                                         class="category-img"
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; border: 2px solid #f0f0f0; transition: all 0.3s ease;">
                                                @else
                                                    <div class="category-icon-placeholder d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; border: 2px solid #f0f0f0; transition: all 0.3s ease;">
                                                        @php
                                                            $categoryLower = strtolower($category->name);
                                                            $icon = 'la-folder';
                                                            
                                                            if (strpos($categoryLower, 'programming') !== false || strpos($categoryLower, 'development') !== false) {
                                                                $icon = 'la-code';
                                                            } elseif (strpos($categoryLower, 'design') !== false) {
                                                                $icon = 'la-paint-brush';
                                                            } elseif (strpos($categoryLower, 'business') !== false) {
                                                                $icon = 'la-briefcase';
                                                            } elseif (strpos($categoryLower, 'marketing') !== false) {
                                                                $icon = 'la-bullhorn';
                                                            } elseif (strpos($categoryLower, 'music') !== false) {
                                                                $icon = 'la-music';
                                                            } elseif (strpos($categoryLower, 'language') !== false) {
                                                                $icon = 'la-language';
                                                            } elseif (strpos($categoryLower, 'science') !== false) {
                                                                $icon = 'la-flask';
                                                            }
                                                        @endphp
                                                        <i class="la {{ $icon }} text-white" style="font-size: 18px;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <span class="category-name font-weight-medium">{{ $category->name }}</span>
                                        </div>
                                        <span class="fs-13 text-gray badge badge-light">{{ $category->course_count }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div><!-- end card -->
                </div><!-- end sidebar -->
            </div><!-- end col-lg-3 -->
            
            <div class="col-lg-9">
                <div class="row">
                    @forelse($all_courses as $course)
                    <div class="col-lg-4 responsive-column-half">
                        <div class="card card-item card-preview" data-tooltip-content="#tooltip_content_{{ $course->id }}">
                            <div class="card-image">
                                <a href="{{ route('course-details', $course->course_name_slug) }}" class="d-block">
                                    <img class="card-img-top lazy" src="{{ asset($course->course_image) }}" data-src="{{ asset($course->course_image) }}" alt="Card image cap">
                                </a>
                                @if($course->discount_price)
                                <div class="course-badge-labels">                                    @php
                                        $discount_percent = $course->selling_price > 0 ? round((($course->selling_price - $course->discount_price) / $course->selling_price) * 100) : 0;
                                    @endphp
                                    <div class="course-badge red">{{ $discount_percent }}% OFF</div>
                                </div>
                                @endif
                            </div><!-- end card-image -->
                            <div class="card-body">
                                <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">{{ $course->label }}</h6>
                                <h5 class="card-title"><a href="{{ route('course-details', $course->course_name_slug) }}">{{ $course->course_name }}</a></h5>
                                <p class="card-text"><a href="#">{{ $course->user->name }}</a></p>
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
                                </div><!-- end rating-wrap -->
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($course->discount_price == NULL)
                                    <p class="card-price text-black font-weight-bold">Rp {{ number_format($course->selling_price * 15000, 0, ',', '.') }}</p>
                                    @else
                                    <p class="card-price text-black font-weight-bold">
                                        Rp {{ number_format($course->discount_price * 15000, 0, ',', '.') }} 
                                        <span class="before-price font-weight-medium">Rp {{ number_format($course->selling_price * 15000, 0, ',', '.') }}</span>
                                    </p>
                                    @endif
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col-lg-4 -->
                    @empty
                    <div class="col-12">
                        <div class="card card-item">
                            <div class="card-body text-center py-5">
                                <h4>Tidak ada kursus yang tersedia</h4>
                                <p class="text-gray">Belum ada kursus yang ditambahkan. Silakan kembali lagi nanti.</p>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div><!-- end row -->
                
                @if($all_courses->hasPages())
                <div class="text-center pt-3">
                    {{ $all_courses->links() }}
                </div><!-- end text-center -->
                @endif
                
            </div><!-- end col-lg-9 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end courses-area -->
<!-- ================================
       END COURSE AREA
================================= -->

<!-- Tooltip Templates -->
@foreach($all_courses as $course)
<div class="tooltip_templates">
    <div id="tooltip_content_{{ $course->id }}">
        <div class="card card-item">
            <div class="card-body">
                <p class="card-text pb-2">Oleh <a href="#">{{ $course->user->name }}</a></p>
                <h5 class="card-title pb-1"><a href="{{ route('course-details', $course->course_name_slug) }}">{{ $course->course_name }}</a></h5>
                <div class="d-flex align-items-center pb-1">
                    <h6 class="ribbon fs-14 mr-2">{{ $course->label }}</h6>
                    <p class="text-success fs-14 font-weight-medium">Diperbarui pada {{ $course->updated_at->format('M Y') }}</p>
                </div>
                <ul class="generic-list-item generic-list-item-bullet generic-list-item--bullet d-flex align-items-center fs-14">
                    <li>{{ $course->duration }} total jam</li>
                    <li>{{ $course->resources ?? 'Semua tingkat' }}</li>
                </ul>
                <p class="card-text pt-1 fs-14 lh-22">{{ Str::limit($course->prerequisites, 100) }}</p>                <ul class="generic-list-item fs-14 py-3">
                    @php
                        $goals = $course->course_goal ?? collect();
                        $goals = $goals->slice(0, 3);
                    @endphp
                    @foreach($goals as $goal)
                    <li><i class="la la-check mr-1 text-black"></i> {{ $goal->goal_name }}</li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn theme-btn w-100 mb-2 add-to-cart-btn" data-course-id="{{ $course->id }}">
                        <i class="la la-shopping-cart fs-18 mr-1"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div><!-- end card -->
    </div>
</div><!-- end tooltip_templates -->
@endforeach

@endsection
