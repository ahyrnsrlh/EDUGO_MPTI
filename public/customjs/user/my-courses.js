$(document).ready(function () {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize lazy loading for images
    $(".lazy").each(function () {
        var $this = $(this);
        var src = $this.data("src");
        if (src) {
            $this.attr("src", src);
        }
    });

    // Handle continue learning button click
    $(".continue-learning").on("click", function (e) {
        e.preventDefault();
        var courseId = $(this).data("course-id");
        // Redirect to course learning page
        // window.location.href = '/course/' + courseId + '/learn';
        console.log("Continue learning course ID:", courseId);
    });

    // Handle add to wishlist from my courses
    $(".add-to-wishlist").on("click", function (e) {
        e.preventDefault();
        var courseId = $(this).data("course-id");
        // Add wishlist functionality here
        console.log("Add to wishlist course ID:", courseId);
    });
});
