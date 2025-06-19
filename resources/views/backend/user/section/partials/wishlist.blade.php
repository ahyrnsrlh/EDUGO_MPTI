<div class="shop-cart wishlist-cart pr-3 mr-3 border-right border-right-gray">
    <ul>
        <li>
            <p class="shop-cart-btn">
                <i class="la la-heart-o"></i>
                <span class="dot-status bg-1"></span>
            </p>
            <ul class="cart-dropdown-menu after-none">

                @forelse($wishlist as $item)
                    <li>
                        <div class="media media-card">
                            <a href="{{ route('course-details', $item->course->course_name_slug ?? '#') }}" class="media-img">
                                <img class="mr-3" src="{{ asset($item->course->course_image) }}" alt="Course image">
                            </a>
                            <div class="media-body">
                                <h5><a href="{{ route('course-details', $item->course->course_name_slug ?? '#') }}">{{ $item->course->course_name }}</a></h5>
                                <span class="d-block lh-18 py-1">{{ $item->course->instructor->name ?? 'Instructor' }}</span>
                                <p class="text-black font-weight-semi-bold lh-18">
                                    @if($item->course->discount_price)
                                        Rp {{ number_format($item->course->selling_price, 0, ',', '.') }} 
                                        <span class="before-price fs-14">Rp {{ number_format($item->course->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format($item->course->selling_price ?? 0, 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                @empty
                    <li>Tidak ada item di daftar favorit.</li>
                @endforelse

                <a href="#" class="btn theme-btn theme-btn-sm theme-btn-transparent lh-28 w-100 mt-3">Tambah ke keranjang <i class="la la-arrow-right icon ml-1"></i></a>


            </ul>
        </li>
    </ul>
</div><!-- end shop-cart -->
