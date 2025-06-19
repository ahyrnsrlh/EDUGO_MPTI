@extends('frontend.master')

@section('content')
<section class="breadcrumb-area section-padding img-bg-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
            <div class="section-heading">
                <h2 class="section__title text-white">Pembayaran Berhasil</h2>
            </div>
            <ul class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                <li>Pembayaran</li>
                <li>Berhasil</li>
            </ul>
        </div>
    </div>
</section>

<section class="contact-area section--padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-item text-center">
                    <div class="card-body">
                        <div class="icon-element icon-element-xxl shadow-sm mb-4 mx-auto" style="background-color: #28a745;">
                            <i class="la la-check text-white" style="font-size: 48px;"></i>
                        </div>
                        
                        <h2 class="card-title fs-24 mb-3">Pembayaran Berhasil!</h2>
                        
                        @if(isset($payment))
                            <div class="alert alert-success" role="alert">
                                <h5 class="alert-heading">Detail Pembayaran</h5>
                                <hr>
                                <p class="mb-1"><strong>ID Pembayaran:</strong> {{ $payment->payment_id }}</p>
                                <p class="mb-1"><strong>Jumlah:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <p class="mb-1"><strong>Status:</strong> 
                                    <span class="badge badge-success">{{ ucfirst($payment->status) }}</span>
                                </p>
                                <p class="mb-0"><strong>Tanggal:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
                            </div>
                        @else
                            <p class="fs-15 text-gray">{{ $message ?? 'Terima kasih! Pembayaran Anda telah berhasil diproses.' }}</p>
                        @endif
                        
                        <p class="fs-15 text-gray mb-4">
                            Kursus yang Anda beli sudah dapat diakses di dashboard Anda. 
                            Selamat belajar dan semoga bermanfaat!
                        </p>
                        
                        <div class="btn-box">
                            <a href="{{ route('user.dashboard') }}" class="btn theme-btn">
                                <i class="la la-dashboard mr-2"></i>Ke Dashboard
                            </a>
                            <a href="{{ route('frontend.home') }}" class="btn theme-btn theme-btn-white ml-3">
                                <i class="la la-home mr-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Clear cart after successful payment
    function clearCartAfterPayment() {
        $.ajax({
            url: "{{ route('cart.clear') }}",
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    console.log('Cart cleared successfully:', response.deleted_items, 'items removed');
                    // Refresh cart display after a short delay
                    setTimeout(function() {
                        refreshCart();
                    }, 500);
                } else {
                    console.log('Failed to clear cart:', response.message);
                    // Still try to refresh cart
                    refreshCart();
                }
            },
            error: function(xhr) {
                console.log('Error clearing cart:', xhr.responseJSON?.message || 'Unknown error');
                // Still try to refresh cart
                refreshCart();
            }
        });
    }
    
    // Refresh cart count after successful payment
    function refreshCart() {
        if (typeof getCart === 'function') {
            getCart();
        } else {
            // Fallback: reload the page to refresh cart
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    }
    
    // Call clear cart and refresh when page loads
    $(document).ready(function() {
        // Clear cart immediately
        clearCartAfterPayment();
        
        // Also refresh cart after a delay
        setTimeout(function() {
            refreshCart();
        }, 1500);
    });
    
    // Auto redirect to dashboard after 10 seconds
    setTimeout(function() {
        if (confirm('Apakah Anda ingin diarahkan ke dashboard?')) {
            window.location.href = "{{ route('user.dashboard') }}";
        }
    }, 10000);
</script>
@endpush
