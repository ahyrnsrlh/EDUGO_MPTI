<ul>
    <li>
        <p class="shop-cart-btn d-flex align-items-center">
            <i class="la la-shopping-cart"></i>
            <span class="product-count">{{ count($cart) }}</span>
        </p>

        @if($cart->count() > 0)
        <ul class="cart-dropdown-menu">
            @foreach($cart as $item)
                <li class="media media-card">
                    <a href="course-details.html" class="media-img">
                        <img src="{{ $item->course->course_image }}" alt="{{ $item->course->course_title }}">
                    </a>
                    <div class="media-body">
                        <h5>
                            <a href="course-details.html">{{ $item->course->course_title }}</a>
                        </h5>
                        <span class="d-block lh-18 py-1">{{ $item->course->user->name }}</span>
                        <p class="text-black font-weight-semi-bold lh-18">
                            Rp {{ number_format($item->course->discount_price * 15000, 0, ',', '.') }}
                            @if($item->course->selling_price > $item->course->discount_price)
                                <span class="before-price fs-14">Rp {{ number_format($item->course->selling_price * 15000, 0, ',', '.') }}</span>
                            @endif
                        </p>
                    </div>
                </li>
            @endforeach

            <li class="media media-card">
                <div class="media-body fs-16">
                    <p class="text-black font-weight-semi-bold lh-18">Total: <span class="cart-total">Rp {{ number_format($subTotal * 15000, 0, ',', '.') }}</span></p>
                </div>
            </li>


            <li>
                <a href="{{ route('checkout.index') }}" class="btn theme-btn w-100">Pergi ke checkout <i class="la la-arrow-right icon ml-1"></i></a>
            </li>
        </ul>
        @endif
    </li>
</ul>

