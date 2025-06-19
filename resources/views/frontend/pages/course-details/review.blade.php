<div class="course-overview-card pt-4">
    <h3 class="fs-24 font-weight-semi-bold pb-4">Ulasan</h3>
    <div class="review-wrap">        <div class="d-flex flex-wrap align-items-center pb-4">
            <form method="get" class="mr-3 flex-grow-1">
                <div class="form-group">
                    <input class="form-control form--control pl-3" type="text"
                        name="search" placeholder="Cari ulasan">
                    <span class="la la-search search-icon"></span>
                </div>
            </form>
            <div class="select-container mb-3">
                <select class="select-container-select">
                    <option value="all-rating">Semua rating</option>
                    <option value="five-star">Lima bintang</option>
                    <option value="four-star">Empat bintang</option>
                    <option value="three-star">Tiga bintang</option>
                    <option value="two-star">Dua bintang</option>
                    <option value="one-star">Satu bintang</option>
                </select>
            </div>
        </div>
        <div class="media media-card border-bottom border-bottom-gray pb-4 mb-4">
            <div class="media-img mr-4 rounded-full">
                <img class="rounded-full lazy" src="images/img-loading.png"
                    data-src="images/small-avatar-1.jpg" alt="User image">
            </div>
            <div class="media-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between pb-1">
                    <h5>Kavi arasan</h5>
                    <div class="review-stars">
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                    </div>
                </div>
                <span class="d-block lh-18 pb-2">sebulan yang lalu</span>
                <p class="pb-2">This is one of the best courses I have taken in Udemy. It is
                    very complete, and it has made continue learning about Java and SQL
                    databases as well.</p>
                <div class="helpful-action">
                    <span class="d-block fs-13">Apakah ulasan ini membantu?</span>
                    <button class="btn">Ya</button>
                    <button class="btn">Tidak</button>
                    <span class="btn-text fs-14 cursor-pointer pl-1" data-toggle="modal"
                        data-target="#reportModal">Laporkan</span>
                </div>
            </div>
        </div><!-- end media -->
        <div class="media media-card border-bottom border-bottom-gray pb-4 mb-4">
            <div class="media-img mr-4 rounded-full">
                <img class="rounded-full lazy" src="images/img-loading.png"
                    data-src="images/small-avatar-2.jpg" alt="User image">
            </div>
            <div class="media-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between pb-1">
                    <h5>Jitesh Shaw</h5>
                    <div class="review-stars">
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                    </div>
                </div>
                <span class="d-block lh-18 pb-2">1 months ago</span>
                <p class="pb-2">This is one of the best courses I have taken in Udemy. It is
                    very complete, and it has made continue learning about Java and SQL
                    databases as well.</p>
                <div class="helpful-action">
                    <span class="d-block fs-13">Apakah ulasan ini membantu?</span>
                    <button class="btn">Ya</button>
                    <button class="btn">Tidak</button>
                    <span class="btn-text fs-14 cursor-pointer pl-1" data-toggle="modal"
                        data-target="#reportModal">Laporkan</span>
                </div>
            </div>
        </div><!-- end media -->
        <div class="media media-card border-bottom border-bottom-gray pb-4 mb-4">
            <div class="media-img mr-4 rounded-full">
                <img class="rounded-full lazy" src="images/img-loading.png"
                    data-src="images/small-avatar-3.jpg" alt="User image">
            </div>
            <div class="media-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between pb-1">
                    <h5>Miguel Sanches</h5>
                    <div class="review-stars">
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                        <span class="la la-star"></span>
                    </div>
                </div>
                <span class="d-block lh-18 pb-2">2 month ago</span>
                <p class="pb-2">This is one of the best courses I have taken in Udemy. It is
                    very complete, and it has made continue learning about Java and SQL
                    databases as well.</p>
                <div class="helpful-action">
                    <span class="d-block fs-13">Apakah ulasan ini membantu?</span>
                    <button class="btn">Ya</button>
                    <button class="btn">Tidak</button>
                    <span class="btn-text fs-14 cursor-pointer pl-1" data-toggle="modal"
                        data-target="#reportModal">Laporkan</span>
                </div>
            </div>
        </div><!-- end media -->
    </div><!-- end review-wrap -->
    <div class="see-more-review-btn text-center">
        <button type="button" class="btn theme-btn theme-btn-transparent">Load more
            reviews</button>
    </div>
</div><!-- end course-overview-card -->
<div class="course-overview-card pt-4">
    <h3 class="fs-24 font-weight-semi-bold pb-4">Add a Review</h3>
    <div class="leave-rating-wrap pb-4">
        <div class="leave-rating leave--rating">
            <input type="radio" name='rate' id="star5" />
            <label for="star5"></label>
            <input type="radio" name='rate' id="star4" />
            <label for="star4"></label>
            <input type="radio" name='rate' id="star3" />
            <label for="star3"></label>
            <input type="radio" name='rate' id="star2" />
            <label for="star2"></label>
            <input type="radio" name='rate' id="star1" />
            <label for="star1"></label>        </div><!-- end leave-rating -->
    </div>
    
    <!-- Button to show review form -->
    <div class="text-center pb-4">
        <button class="btn theme-btn theme-btn-sm" onclick="alert('Fitur review akan segera tersedia.');">
            <i class="la la-edit mr-1"></i> Tulis Ulasan
        </button>
    </div>
    
    <!-- Form Review (Hidden for now) -->
    <div class="review-form-section" style="display: none;">
        <form action="javascript:void(0);" class="row" onsubmit="alert('Fitur review akan segera tersedia.');">
            <div class="input-box col-lg-6">
                <label class="label-text">Nama</label>
                <div class="form-group">
                    <input class="form-control form--control" type="text" name="name"
                        placeholder="Nama Anda">
                    <span class="la la-user input-icon"></span>
                </div>
            </div><!-- end input-box -->
        <div class="input-box col-lg-6">
            <label class="label-text">Email</label>
            <div class="form-group">
                <input class="form-control form--control" type="email" name="email"
                    placeholder="Alamat Email">
                <span class="la la-envelope input-icon"></span>
            </div>
        </div><!-- end input-box -->
        <div class="input-box col-lg-12">
            <label class="label-text">Pesan</label>            <div class="form-group">
                <textarea class="form-control form--control pl-3" name="message" placeholder="Tulis Pesan" rows="5"></textarea>
            </div>
        </div><!-- end input-box -->
        <div class="btn-box col-lg-12">
            <div class="custom-control custom-checkbox mb-3 fs-15">
                <input type="checkbox" class="custom-control-input" id="saveCheckbox"
                    required>
                <label class="custom-control-label custom--control-label"
                    for="saveCheckbox">
                    Simpan nama dan email saya di browser ini untuk komentar selanjutnya.
                </label>
            </div><!-- end custom-control -->            <button class="btn theme-btn" type="submit">Kirim Ulasan</button>
        </div><!-- end btn-box -->
        </form>
    </div><!-- end review-form-section -->
</div><!-- end course-overview-card -->
