<section class="hero-area-modern">
    <!-- Background decorative elements -->
    <div class="hero-decorations">
        <div class="decoration-circle decoration-1"></div>
        <div class="decoration-circle decoration-2"></div>
        <div class="decoration-circle decoration-3"></div>
        <div class="decoration-circle decoration-4"></div>
        <!-- Additional SVG shapes -->
        <div class="decoration-shape shape-1">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                <circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.1)"/>
            </svg>
        </div>
        <div class="decoration-shape shape-2">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                <rect x="10" y="10" width="60" height="60" fill="rgba(255,255,255,0.05)" rx="10"/>
            </svg>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center min-vh-100">
            <!-- Left content -->
            <div class="col-lg-6 col-md-12">
                <div class="hero-content-modern py-5">
                    <div class="hero-badge mb-4 animate-fade-in">
                        <span class="badge-modern">
                            <i class="la la-graduation-cap mr-2"></i> Platform Pembelajaran SMK 1 Mendo Barat
                        </span>
                    </div>
                    
                    <h1 class="hero-title text-white mb-4 animate-fade-in-up">
                        Kembangkan 
                        <span class="highlight-text position-relative">
                            Keahlian
                            <svg class="underline-svg" viewBox="0 0 120 12" fill="none">
                                <path d="M2 8C25 3, 50 1, 75 4C95 6, 110 3, 118 5" stroke="#ffd700" stroke-width="3" fill="none"/>
                            </svg>
                        </span>
                        <br>Bersama SMK 1 Mendo Barat
                    </h1>
                    
                    <p class="hero-description text-white mb-5 animate-fade-in-up">
                        Platform pembelajaran modern dan interaktif yang dirancang khusus untuk mendukung proses pembelajaran di SMK 1 Mendo Barat. Akses materi berkualitas tinggi dari instruktur berpengalaman kapan saja, di mana saja.
                    </p>

                    <!-- Stats -->
                    <div class="hero-stats mb-4 animate-fade-in-up">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number text-white">800+</div>
                                    <div class="stat-label text-white-50">Siswa</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number text-white">50+</div>
                                    <div class="stat-label text-white-50">Kursus</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number text-white">95%</div>
                                    <div class="stat-label text-white-50">Kepuasan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="hero-actions d-flex flex-wrap align-items-center mb-5 animate-fade-in-up">
                        <a href="{{ route('all.courses') }}" class="btn btn-hero-primary btn-lg mr-3 mb-3">
                            <i class="la la-play mr-2"></i> Mulai Belajar
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-hero-outline btn-lg mb-3">
                            Daftar Gratis <i class="la la-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <!-- Search section -->
                    <div class="hero-search mt-4 animate-fade-in-up">
                        <div class="search-wrapper">
                            <h6 class="search-title text-white mb-3">Cari kursus yang tepat untuk Anda:</h6>
                            <form class="search-form" action="{{ route('all.courses') }}" method="GET">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-5">
                                        <select name="category" class="form-select hero-select">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control hero-input" placeholder="Cari kursus...">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-search w-100">
                                            <i class="la la-search mr-1"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right content with image -->
            <div class="col-lg-6 col-md-12">
                <div class="hero-image-wrapper position-relative animate-fade-in-right">
                    <!-- Main image container -->
                    <div class="hero-main-image">
                        <div class="image-bg-circle">
                            <img src="{{ asset('frontend/images/hero2.svg') }}" 
                                 alt="Student Learning" 
                                 class="img-fluid main-hero-img">
                        </div>
                        
                        <!-- Floating cards with improved design -->
                        <div class="floating-card card-1 animate-float-1">
                            <div class="card-icon">
                                <i class="la la-graduation-cap"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-number">5,000+</div>
                                <div class="card-label">Siswa Aktif</div>
                            </div>
                        </div>
                        
                        <div class="floating-card card-2 animate-float-2">
                            <div class="card-icon">
                                <i class="la la-trophy"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-number">98%</div>
                                <div class="card-label">Tingkat Kelulusan</div>
                            </div>
                        </div>

                        <div class="floating-card card-3 animate-float-3">
                            <div class="card-icon">
                                <i class="la la-book"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-number">250+</div>
                                <div class="card-label">Kursus Premium</div>
                            </div>
                        </div>

                        <!-- Additional floating elements -->
                        <div class="floating-shape shape-circle-1"></div>
                        <div class="floating-shape shape-circle-2"></div>
                        <div class="floating-dot dot-1"></div>
                        <div class="floating-dot dot-2"></div>
                        <div class="floating-dot dot-3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trusted by section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="trusted-by text-center animate-fade-in-up">
                    <p class="text-white-50 mb-3">Dipercaya oleh lebih dari 5,000+ siswa di seluruh Indonesia</p>
                    <div class="trust-indicators d-flex justify-content-center align-items-center flex-wrap">
                        <div class="trust-item mx-3 mb-2">
                            <i class="la la-star text-warning"></i>
                            <span class="text-white ml-1">4.9/5 Rating</span>
                        </div>
                        <div class="trust-item mx-3 mb-2">
                            <i class="la la-shield text-info"></i>
                            <span class="text-white ml-1">Sertifikat Resmi</span>
                        </div>
                        <div class="trust-item mx-3 mb-2">
                            <i class="la la-clock text-success"></i>
                            <span class="text-white ml-1">Belajar Fleksibel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
