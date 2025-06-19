@extends('frontend.master')

@section('content')
<section class="breadcrumb-area section-padding img-bg-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
            <div class="section-heading">
                <h2 class="section__title text-white">Pembayaran Gagal</h2>
            </div>
            <ul class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                <li>Pembayaran</li>
                <li>Gagal</li>
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
                        <div class="icon-element icon-element-xxl shadow-sm mb-4 mx-auto" style="background-color: #dc3545;">
                            <i class="la la-times text-white" style="font-size: 48px;"></i>
                        </div>
                        
                        <h2 class="card-title fs-24 mb-3">Pembayaran Gagal</h2>
                        
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">Oops! Terjadi Kesalahan</h5>
                            <hr>
                            <p class="mb-0">{{ $message ?? 'Pembayaran Anda tidak dapat diproses. Silakan coba lagi atau hubungi customer service.' }}</p>
                        </div>
                        
                        <p class="fs-15 text-gray mb-4">
                            Jangan khawatir, tidak ada biaya yang dikenakan untuk transaksi yang gagal. 
                            Anda dapat mencoba melakukan pembayaran kembali.
                        </p>
                        
                        <div class="btn-box">
                            <a href="{{ route('cart') }}" class="btn theme-btn">
                                <i class="la la-shopping-cart mr-2"></i>Coba Lagi
                            </a>
                            <a href="{{ route('frontend.home') }}" class="btn theme-btn theme-btn-white ml-3">
                                <i class="la la-home mr-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                        
                        <div class="contact-info mt-4">
                            <h5 class="fs-16 pb-2">Butuh Bantuan?</h5>
                            <p class="text-gray fs-14">
                                Hubungi customer service kami di:<br>
                                <strong>Email:</strong> support@youtubelms.com<br>
                                <strong>WhatsApp:</strong> +62 812-3456-7890
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
