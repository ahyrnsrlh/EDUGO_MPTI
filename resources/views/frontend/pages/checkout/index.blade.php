@extends('frontend.master')

@section('content')



    @include('frontend.section.breadcrumb', ['title' => 'Checkout'])
    <!-- ================================
                END BREADCRUMB AREA
            ================================= -->

    <!-- ================================
                   START CONTACT AREA
            ================================= -->
    <form id="payment-form" method="post" action="{{ route('order') }}">
        @csrf

        <section class="cart-area section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card card-item">
                            <div class="card-body">
                                <h3 class="card-title fs-22 pb-3">Detail Penagihan</h3>
                                <div class="divider"><span></span></div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="input-box col-lg-6">
                                        <label class="label-text">Nama Depan</label>
                                        <div class="form-group">
                                            <input class="form-control form--control" type="text" name="first_name"
                                                placeholder="e.g. Alex" value="{{ $user ? $user->first_name : '' }}" required>
                                            <span class="la la-user input-icon"></span>
                                        </div>
                                    </div><!-- end input-box -->
                                    <div class="input-box col-lg-6">
                                        <label class="label-text">Nama Belakang</label>
                                        <div class="form-group">
                                            <input class="form-control form--control" type="text" name="last_name"
                                                placeholder="e.g. Smith" value="{{ $user ? $user->last_name : '' }}" required>
                                            <span class="la la-user input-icon"></span>
                                        </div>
                                    </div><!-- end input-box -->
                                    <div class="input-box col-lg-12">
                                        <label class="label-text">Alamat Email</label>
                                        <div class="form-group">
                                            <input class="form-control form--control" type="email" name="email"
                                                placeholder="e.g. alexsmith@gmail.com"
                                                value="{{ $user ? $user->email : '' }}" required>
                                            <span class="la la-envelope input-icon"></span>
                                        </div>
                                    </div><!-- end input-box -->
                                    <div class="input-box col-lg-12">
                                        <label class="label-text">Nomor Telepon</label>
                                        <div class="form-group">
                                            <input id="phone" class="form-control form--control" type="tel"
                                                name="phone" value="{{ $user ? $user->phone : '' }}" required>
                                            <span class="la la-phone input-icon"></span>
                                        </div>
                                    </div><!-- end input-box -->
                                    <div class="input-box col-lg-12">
                                        <label class="label-text">Alamat</label>
                                        <div class="form-group">
                                            <input class="form-control form--control" type="text" name="address"
                                                placeholder="e.g. Jl. Merdeka No. 123, Jakarta"
                                                value="{{ $user ? $user->address : '' }}"  required>
                                            <span class="la la-map-marker input-icon"></span>
                                        </div>
                                    </div><!-- end input-box -->
                                </div>






                            </div><!-- end card-body -->
                        </div><!-- end card -->
                        <div class="card card-item">
                            <div class="card-body">
                                <h3 class="card-title fs-22 pb-3">Pilih Metode Pembayaran</h3>
                                <div class="divider"><span></span></div>
                                <div class="payment-option-wrap">

                                    <!-- Xendit Payment -->
                                    <div class="payment-tab">
                                        <div class="payment-tab-toggle">
                                            <input id="xendit" name="payment_type" type="radio" value="xendit" checked>
                                            <label for="xendit">Xendit</label>
                                            <img class="payment-logo" src="{{ asset('frontend/images/xendit.png') }}" 
                                                 alt="Xendit" style="width: 60px;">
                                        </div>
                                        <div class="payment-tab-content">
                                            <p class="fs-15 lh-24">
                                                Bayar dengan berbagai metode pembayaran Indonesia: 
                                                Bank Transfer, E-wallet (OVO, DANA, LinkAja, ShopeePay), 
                                                Kartu Kredit/Debit, atau minimarket (Alfamart, Indomaret).
                                            </p>
                                        </div>
                                    </div><!-- end payment-tab -->


                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col-lg-7 -->
                    <div class="col-lg-5">
                        <div class="card card-item">
                            <div class="card-body">
                                <h3 class="card-title fs-22 pb-3">Detail Pesanan</h3>
                                <div class="divider"><span></span></div>
                                <div class="order-details-lists">

                                    @forelse($cart as  $item)
                                        <div class="media media-card border-bottom border-bottom-gray pb-3 mb-3">
                                            <a href="course-details.html" class="media-img">
                                                <img src="{{ asset($item->course->course_image) }}" alt="Cart image">
                                            </a>

                                            <input type="hidden" name="course_id[]" value="{{ $item->course->id }}" />
                                            <input type="hidden" name="course_name[]"
                                                value="{{ $item->course->course_name }}" />
                                            <input type="hidden" name="course_image[]"
                                                value="{{ $item->course->course_image }}" />
                                            <input type="hidden" name="course_price[]"
                                                value="{{ $item->course->discount_price ? $item->course->discount_price : $item->course->selling_price }}" />
                                            <input type="hidden" name="instructor_id[]" value="{{$item->course->instructor_id}}" />
                                            <div class="media-body">
                                                <h5 class="fs-15 pb-2"><a
                                                        href="{{ route('course-details', $item->course->course_name_slug) }}">{{ $item->course->course_name }}</a>
                                                </h5>
                                                <p class="text-black font-weight-semi-bold lh-18">
                                                    Rp {{ number_format($item->course->discount_price ? $item->course->discount_price : $item->course->selling_price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div><!-- end media -->
                                    @empty
                                        <p>Tidak ada data keranjang!</p>
                                    @endforelse

                                </div><!-- end order-details-lists -->
                                <a href="/cart" class="btn-text"><i class="la la-edit mr-1"></i>Edit</a>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                        <div class="card card-item">
                            <div class="card-body">
                                <h3 class="card-title fs-22 pb-3">Ringkasan Pesanan</h3>
                                <div class="divider"><span></span></div>
                                <ul class="generic-list-item generic-list-item-flash fs-15">
                                    <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                                        <span class="text-black">Harga asli:</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        <input type="hidden" name="original_price" value="{{ $total }}" />
                                    </li>

                                    @if (session()->get('coupon'))
                                        <li
                                            class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                                            <span class="text-black">Diskon kupon:</span>
                                            <span>-Rp {{ number_format(session()->get('coupon'), 0, ',', '.') }}</span>

                                        </li>
                                    @endif
                                    <li class="d-flex align-items-center justify-content-between font-weight-bold">
                                        <span class="text-black">Total:</span>
                                        <span>Rp {{ number_format(($total - session()->get('coupon')), 0, ',', '.') }}</span>
                                        <input type="hidden" name="total_price"
                                            value="{{ ($total - session()->get('coupon')) }}" />
                                    </li>
                                </ul>
                                <div class="btn-box border-top border-top-gray pt-3">
                                    <p class="fs-14 lh-22 mb-2">Platform pembelajaran online kami diharuskan oleh hukum untuk mengumpulkan pajak transaksi yang berlaku untuk pembelian yang dilakukan di jurisdiksi pajak tertentu.</p>
                                    <p class="fs-14 lh-22 mb-3">Dengan menyelesaikan pembelian Anda, Anda menyetujui <a
                                            href="#" class="text-color hover-underline">Syarat dan Ketentuan Layanan.</a></p>
                                    <button type="submit" class="btn theme-btn w-100" id="checkout-btn">
                                        <span id="btn-text">Lanjutkan Pembayaran</span>
                                        <span id="btn-loading" style="display: none;">
                                            <i class="la la-spinner la-spin"></i> Memproses...
                                        </span>
                                        <i class="la la-arrow-right icon ml-1" id="btn-icon"></i>
                                    </button>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col-lg-5 -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>

    </form>
@endsection




@push('scripts')
<script>
$(document).ready(function() {
    // Handle form submission
    $('#payment-form').on('submit', function(e) {
        e.preventDefault();
        
        const paymentType = $('input[name="payment_type"]:checked').val();
        const form = $(this);
        const submitBtn = $('#checkout-btn');
        const btnText = $('#btn-text');
        const btnLoading = $('#btn-loading');
        const btnIcon = $('#btn-icon');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        btnText.hide();
        btnIcon.hide();
        btnLoading.show();
        
        if (paymentType === 'xendit') {
            // Handle Xendit payment
            const formData = new FormData(form[0]);
            
            $.ajax({
                url: '{{ route("xendit.payment") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Redirect to Xendit payment page
                        window.location.href = response.payment_url;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: response.message || 'Terjadi kesalahan saat memproses pembayaran.'
                        });
                        resetButton();
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat memproses pembayaran.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: errorMessage
                    });
                    resetButton();
                }
            });
        } else {
            // Handle other payment methods if any
            form.off('submit').submit();
        }
        
        function resetButton() {
            submitBtn.prop('disabled', false);
            btnText.show();
            btnIcon.show();
            btnLoading.hide();
        }
    });
    
    // Handle payment method selection
    $('input[name="payment_type"]').on('change', function() {
        const selectedMethod = $(this).val();
        const btnText = $('#btn-text');
        
        // Only Xendit is available now
        btnText.text('Bayar dengan Xendit');
    });
});
</script>
@endpush
