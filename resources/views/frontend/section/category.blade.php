<section class="category-area py-5" style="background-color: white; margin-bottom: 40px;">
    <div class="container">
        <!-- Header Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-9">
                <div class="category-header">
                    <h2 class="category-title" style="font-size: 2.5rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1rem;">
                        Program Keahlian<br>SMK 1 Mendo Barat!
                    </h2>
                    <p class="category-description" style="font-size: 1.1rem; color: #6c757d; line-height: 1.6;">
                        Temukan berbagai program keahlian yang sesuai dengan minat dan bakat Anda. Bergabunglah dengan ribuan siswa SMK 1 Mendo Barat yang telah meningkatkan kemampuan mereka melalui platform EDUGO.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 text-end">
                <!-- Navigation Arrow -->
                <button class="btn-arrow-next" style="background: none; border: none; font-size: 2rem; color: #6c757d; cursor: pointer; padding: 10px; border-radius: 50%; transition: all 0.3s ease;" onclick="scrollCategories()">
                    ❯
                </button>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="category-modern-wrapper">
            <div class="row">
                @foreach($all_categories as $index => $item)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <a href="{{ route('courses.by.category', $item->slug) }}" class="text-decoration-none">
                        <div class="category-modern-card category-card-{{ $index % 4 }}">
                            <!-- Icon Container -->
                            <div class="category-icon-wrapper">
                                <div class="category-icon category-icon-{{ $index % 4 }}">
                                    @if($index % 4 == 0)
                                        <!-- Education Icon -->
                                        <svg width="40" height="40" fill="white" viewBox="0 0 24 24">
                                            <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                                        </svg>
                                    @elseif($index % 4 == 1)
                                        <!-- Language Icon -->
                                        <svg width="40" height="40" fill="white" viewBox="0 0 24 24">
                                            <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                                        </svg>
                                    @elseif($index % 4 == 2)
                                        <!-- Academic Icon -->
                                        <svg width="40" height="40" fill="white" viewBox="0 0 24 24">
                                            <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                                        </svg>
                                    @else
                                        <!-- Star Icon -->
                                        <svg width="40" height="40" fill="white" viewBox="0 0 24 24">
                                            <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Category Content -->
                            <div class="category-modern-content">
                                <h3 class="category-modern-title" style="font-size: 1.4rem; font-weight: 600; color: #1a1a1a; margin-bottom: 0.5rem; line-height: 1.3;">
                                    {{ $item->name }}
                                </h3>
                                <p class="category-modern-count" style="color: #6c757d; font-size: 1rem; margin: 0;">
                                    {{ $item->course_count ?? 0 }} Kursus
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

                @if($all_categories->count() > 0 && $all_categories->count() % 4 != 0)
                    @for($i = $all_categories->count(); $i < ceil($all_categories->count() / 4) * 4; $i++)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="category-modern-card" style="background: white; border-radius: 20px; padding: 2rem 1.5rem; text-align: center; border: 1px solid #e9ecef; transition: all 0.3s ease; box-shadow: 0 5px 20px rgba(0,0,0,0.08); height: 100%; cursor: pointer; opacity: 0.5;">
                            <div class="category-icon-wrapper" style="margin-bottom: 1.5rem;">
                                <div class="category-icon" style="width: 80px; height: 80px; margin: 0 auto; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);">
                                    <svg width="40" height="40" fill="white" viewBox="0 0 24 24">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="category-modern-content">
                                <h3 class="category-modern-title" style="font-size: 1.4rem; font-weight: 600; color: #9ca3af; margin-bottom: 0.5rem; line-height: 1.3;">
                                    Segera Hadir
                                </h3>
                                <p class="category-modern-count" style="color: #9ca3af; font-size: 1rem; margin: 0;">
                                    Kategori Baru
                                </p>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.category-modern-wrapper {
    position: relative;
    overflow: visible;
}

.category-modern-wrapper .row {
    margin: 0 -15px;
}

.category-modern-wrapper .row > [class*="col-"] {
    padding: 0 15px;
    display: flex;
    flex-direction: column;
}

.category-modern-card {
    background: white;
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    height: 100%;
    cursor: pointer;
}

.category-modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.category-icon-wrapper {
    margin-bottom: 1.5rem;
}

.category-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-icon-0 {
    background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
}

.category-icon-1 {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
}

.category-icon-2 {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.category-icon-3 {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.btn-arrow-next:hover {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    transform: scale(1.1);
}

/* Responsive Design */
@media (max-width: 1199px) {
    .col-lg-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (max-width: 991px) {
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .category-title {
        font-size: 2rem !important;
    }
    
    .category-modern-card {
        padding: 1.5rem 1rem !important;
        min-height: 250px;
    }
}

@media (max-width: 767px) {
    .col-sm-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .category-icon {
        width: 60px !important;
        height: 60px !important;
    }
    
    .category-icon svg {
        width: 30px !important;
        height: 30px !important;
    }
}

@media (max-width: 575px) {
    .col-sm-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .category-modern-card {
        margin-bottom: 1rem;
    }
}

/* Link Styles */
a.text-decoration-none {
    color: inherit;
    display: block;
    height: 100%;
}

a.text-decoration-none:hover {
    color: inherit;
    text-decoration: none;
}
</style>

<script>
function scrollCategories() {
    const container = document.querySelector('.category-modern-wrapper');
    if (container) {
        container.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    }
}

// Make container horizontally scrollable on smaller screens
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.category-modern-wrapper');
    const row = wrapper.querySelector('.row');
    
    function checkScreenSize() {
        if (window.innerWidth < 992) {
            // On smaller screens, enable horizontal scroll
            wrapper.style.overflowX = 'auto';
            wrapper.style.overflowY = 'hidden';
            row.style.flexWrap = 'nowrap';
            row.style.width = 'max-content';
        } else {
            // On larger screens, use normal grid
            wrapper.style.overflowX = 'visible';
            wrapper.style.overflowY = 'visible';
            row.style.flexWrap = 'wrap';
            row.style.width = 'auto';
        }
    }
    
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
});
</script>
