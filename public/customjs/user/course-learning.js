$(document).ready(function () {
    // Initialize video player
    initializeVideoPlayer();

    // Handle lecture click with AJAX loading
    $(document).on("click", ".lecture-item", function (e) {
        e.preventDefault();
        
        let lectureId = $(this).data("lecture-id");
        let lectureUrl = $(this).data("lecture-url");
        let lectureTitle = $(this).data("lecture-title");
        let lectureContent = $(this).data("lecture-content");
        
        // Don't reload if already active
        if ($(this).hasClass('active')) {
            return;
        }

        // Update active lecture
        $(".lecture-item").removeClass("active");
        $(this).addClass("active");

        // Update lecture content without page reload
        updateLectureContent(lectureId, lectureUrl, lectureTitle, lectureContent);
        
        // Update URL without reload
        let courseId = window.location.pathname.split('/')[3];
        let newUrl = `/user/course/${courseId}/lecture/${lectureId}`;
        window.history.pushState({lectureId: lectureId}, '', newUrl);
    });

    // Handle section toggle
    $(".section-toggle").on("click", function () {
        let section = $(this).closest(".course-section");
        let lectureList = section.find(".lecture-list");

        lectureList.slideToggle();
        $(this).find("i").toggleClass("la-angle-down la-angle-up");
    });

    // Mark lecture as completed
    $(".mark-complete-btn").on("click", function () {
        let lectureId = $(this).data("lecture-id");
        markLectureComplete(lectureId);
    });

    // Handle browser back/forward
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.lectureId) {
            location.reload(); // Simple reload for back/forward navigation
        }
    });

    function initializeVideoPlayer() {
        // Initialize YouTube player or other video player
        if ($("#video-player").length) {
            // Video player initialization code here
        }
    }

    function updateLectureContent(lectureId, lectureUrl, lectureTitle, lectureContent) {
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
        if (lectureUrl && lectureUrl.includes("youtube.com")) {
            let videoId = extractYouTubeVideoId(lectureUrl);
            if (videoId) {
                loadYouTubeVideo(videoId, lectureTitle);
            }
        } else if (lectureUrl && lectureUrl.includes("youtu.be")) {
            let videoId = extractYouTubeVideoId(lectureUrl);
            if (videoId) {
                loadYouTubeVideo(videoId, lectureTitle);
            }
        } else if (lectureUrl) {
            loadVideoUrl(lectureUrl);
        } else {
            // Show content only (no video)
            showNoVideoMessage();
        }
    }

    function updateLectureDescription(content) {
        let lectureContent = $(".lecture-content .content-text");
        if (lectureContent.length) {
            lectureContent.html(content.replace(/\n/g, '<br>'));
        } else {
            // Create lecture content section if it doesn't exist
            let contentHtml = `
                <div class="lecture-content p-4">
                    <h5>Deskripsi Kuliah</h5>
                    <div class="content-text">
                        ${content.replace(/\n/g, '<br>')}
                    </div>
                </div>
            `;
            $(".video-container-wrapper").after(contentHtml);
        }
    }

        // Update video player
        if (lectureUrl && lectureUrl.includes("youtube.com")) {
            let videoId = extractYouTubeVideoId(lectureUrl);
            if (videoId) {
                loadYouTubeVideo(videoId);
            }
        } else if (lectureUrl) {
            loadVideoUrl(lectureUrl);
        } else {
            // Show content only (no video)
            $("#video-container").html(
                '<div class="alert alert-info">This lecture contains text content only.</div>'
            );
        }

        // Update progress
        updateProgress();
    }    function extractYouTubeVideoId(url) {
        // More comprehensive YouTube URL patterns
        const patterns = [
            /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?youtu\.be\/([a-zA-Z0-9_-]{11})/,
            /(?:https?:\/\/)?(?:www\.)?youtube\.com\/v\/([a-zA-Z0-9_-]{11})/
        ];
        
        for (let pattern of patterns) {
            const match = url.match(pattern);
            if (match && match[1]) {
                return match[1];
            }
        }
        
        return null;
    }    function loadYouTubeVideo(videoId) {
        let embedUrl = `https://www.youtube.com/embed/${videoId}?rel=0&showinfo=0&modestbranding=1`;
        let iframe = `
            <div class="ratio ratio-16x9">
                <iframe src="${embedUrl}" 
                        title="Video pembelajaran"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                </iframe>
            </div>`;
        $("#video-container").html(iframe);
    }    function loadVideoUrl(url) {
        let video = `
            <div class="ratio ratio-16x9">
                <video controls class="w-100 h-100">
                    <source src="${url}" type="video/mp4">
                    <source src="${url}" type="video/webm">
                    <source src="${url}" type="video/ogg">
                    Browser Anda tidak mendukung pemutaran video.
                </video>
            </div>`;
        $("#video-container").html(video);
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
        let totalLectures = $(".lecture-item").length;
        let completedLectures = $(".lecture-item.completed").length;
        let progressPercent = Math.round(
            (completedLectures / totalLectures) * 100
        );

        $(".progress-bar").css("width", progressPercent + "%");
        $(".progress-text").text(
            `${completedLectures} of ${totalLectures} lectures completed (${progressPercent}%)`
        );
    }

    function showMessage(type, message) {
        let alertClass = type === "success" ? "alert-success" : "alert-danger";
        let alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        // Remove existing alerts
        $(".alert").remove();

        // Add new alert at the top
        $(".course-learning-container").prepend(alertHtml);

        // Auto remove after 3 seconds
        setTimeout(function () {
            $(".alert").fadeOut();
        }, 3000);
    }

    // Load first lecture on page load
    if ($(".lecture-item").length > 0) {
        $(".lecture-item").first().click();
    }
});
