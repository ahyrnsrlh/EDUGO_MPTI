$(document).ready(function () {
    // Initialize video player
    initializeVideoPlayer();

    // Handle lecture click with better navigation
    $(document).on("click", ".lecture-item", function (e) {
        e.preventDefault();

        let lectureId = $(this).data("lecture-id");
        let lectureUrl = $(this).data("lecture-url");
        let lectureTitle = $(this).data("lecture-title");
        let lectureContent = $(this).data("lecture-content");

        // Don't reload if already active
        if ($(this).hasClass("active")) {
            return;
        }

        // Add loading state
        $(this).addClass("loading");

        // Update active lecture
        $(".lecture-item").removeClass("active");
        $(this).addClass("active");

        // Update lecture content without page reload
        updateLectureContent(
            lectureId,
            lectureUrl,
            lectureTitle,
            lectureContent
        );

        // Update URL without reload
        try {
            let courseId = window.location.pathname.split("/")[3];
            let newUrl = `/user/course/${courseId}/lecture/${lectureId}`;
            window.history.pushState({ lectureId: lectureId }, "", newUrl);
        } catch (e) {
            // Handle URL update error gracefully
            console.log("Could not update URL");
        }

        // Remove loading state
        setTimeout(() => {
            $(this).removeClass("loading");
        }, 500);
    });

    // Handle section toggle
    $(".section-toggle").on("click", function () {
        let section = $(this).closest(".course-section");
        let lectureList = section.find(".lecture-list");

        lectureList.slideToggle();
        $(this).find("i").toggleClass("la-angle-down la-angle-up");
    });

    // Mark lecture as completed
    $(document).on("click", ".mark-complete-btn", function () {
        let lectureId = $(this).data("lecture-id");
        markLectureComplete(lectureId);
    });

    // Handle browser back/forward
    window.addEventListener("popstate", function (event) {
        if (event.state && event.state.lectureId) {
            location.reload(); // Simple reload for back/forward navigation
        }
    });

    function initializeVideoPlayer() {
        // Initialize video player if exists
        if ($(".video-container-wrapper").length) {
            console.log("Video player initialized");
        }
    }

    function updateLectureContent(
        lectureId,
        lectureUrl,
        lectureTitle,
        lectureContent
    ) {
        // Update lecture title
        $(".card-title").text(lectureTitle);

        // Update video player
        updateVideoPlayer(lectureUrl, lectureTitle);

        // Update lecture description
        if (lectureContent) {
            updateLectureDescription(lectureContent);
        }

        // Update progress
        updateProgress();
    }

    function updateVideoPlayer(lectureUrl, lectureTitle) {
        if (!lectureUrl) {
            showNoVideoMessage();
            return;
        }

        if (
            lectureUrl.includes("youtube.com") ||
            lectureUrl.includes("youtu.be")
        ) {
            let videoId = extractYouTubeVideoId(lectureUrl);
            if (videoId) {
                loadYouTubeVideo(videoId, lectureTitle);
            } else {
                showVideoError();
            }
        } else {
            loadVideoUrl(lectureUrl);
        }
    }

    function updateLectureDescription(content) {
        let lectureContent = $(".lecture-content .content-text");
        if (lectureContent.length) {
            lectureContent.html(content.replace(/\n/g, "<br>"));
        } else {
            // Create lecture content section if it doesn't exist
            let contentHtml = `
                <div class="lecture-content p-4">
                    <h5>Deskripsi Kuliah</h5>
                    <div class="content-text">
                        ${content.replace(/\n/g, "<br>")}
                    </div>
                </div>
            `;
            $(".video-container-wrapper").after(contentHtml);
        }
    }

    function extractYouTubeVideoId(url) {
        // More comprehensive YouTube URL patterns
        const patterns = [
            /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?youtu\.be\/([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?(?:www\.)?youtube\.com\/v\/([a-zA-Z0-9_-]{11})/,
        ];

        for (let pattern of patterns) {
            const match = url.match(pattern);
            if (match && match[1]) {
                return match[1];
            }
        }

        return null;
    }

    function loadYouTubeVideo(videoId, title = "Video pembelajaran") {
        let embedUrl = `https://www.youtube.com/embed/${videoId}?rel=0&showinfo=0&modestbranding=1&iv_load_policy=3`;
        let iframe = `
            <div class="video-player-container">
                <div class="video-responsive">
                    <iframe 
                        id="video-player"
                        src="${embedUrl}" 
                        title="${title}"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>`;
        $(".video-container-wrapper").html(iframe);
    }

    function loadVideoUrl(url) {
        let video = `
            <div class="video-player-container">
                <div class="video-responsive">
                    <video controls class="w-100 h-100">
                        <source src="${url}" type="video/mp4">
                        <source src="${url}" type="video/webm">
                        <source src="${url}" type="video/ogg">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                </div>
            </div>`;
        $(".video-container-wrapper").html(video);
    }

    function showNoVideoMessage() {
        let message = `
            <div class="alert alert-info m-4">
                <i class="la la-info-circle"></i>
                Kuliah ini hanya berisi konten teks.
            </div>`;
        $(".video-container-wrapper").html(message);
    }

    function showVideoError() {
        let error = `
            <div class="alert alert-warning m-4">
                <i class="la la-exclamation-triangle"></i>
                Video tidak dapat dimuat. Silakan coba lagi nanti.
            </div>`;
        $(".video-container-wrapper").html(error);
    }

    function markLectureComplete(lectureId) {
        $.ajax({
            url: `/user/lecture/${lectureId}/complete`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status === "success") {
                    // Update UI to show completion
                    $(`.lecture-item[data-lecture-id="${lectureId}"]`).addClass(
                        "completed"
                    );
                    updateProgress();

                    // Show success message
                    showMessage("success", "Lecture marked as completed!");
                }
            },
            error: function (xhr) {
                showMessage("error", "Error marking lecture as completed");
            },
        });
    }

    function updateProgress() {
        // Update course progress if needed
        let totalLectures = $(".lecture-item").length;
        let completedLectures = $(".lecture-item.completed").length;
        let progress =
            totalLectures > 0 ? (completedLectures / totalLectures) * 100 : 0;

        // Update progress bar if exists
        $(".progress-bar").css("width", progress + "%");
        $(".progress-text").text(
            `${completedLectures} dari ${totalLectures} kuliah selesai`
        );
    }

    function showMessage(type, message) {
        // Create toast notification
        let alertClass = type === "success" ? "alert-success" : "alert-danger";
        let toast = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        $("body").append(toast);

        // Auto remove after 3 seconds
        setTimeout(function () {
            $(".alert").fadeOut();
        }, 3000);
    }

    // Auto-scroll to active lecture on page load
    if ($(".lecture-item.active").length) {
        let activeLecture = $(".lecture-item.active");
        activeLecture[0].scrollIntoView({
            behavior: "smooth",
            block: "center",
        });
    }
});
