/* Course Index DataTable Enhancement */

// This script enhances the course index page with better DataTable handling
// It prevents the "Cannot reinitialise DataTable" error

$(document).ready(function () {
    "use strict";

    // Configuration object for DataTable
    const dataTableConfig = {
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, "asc"]],
        columnDefs: [
            { orderable: false, targets: [-1] },
            { width: "5%", targets: 0 },
            { width: "10%", targets: 1 },
            { width: "25%", targets: 2 },
            { width: "15%", targets: 3 },
            { width: "15%", targets: 4 },
            { width: "15%", targets: 5 },
            { width: "10%", targets: 6 },
            { width: "10%", targets: 7 },
        ],
        language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(disaring dari _MAX_ total data)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya",
            },
        },
    };

    // Global table variable
    let courseTable;

    // Function to safely initialize DataTable
    function initCourseTable() {
        try {
            // Check if table exists
            if (!$("#example").length) {
                console.log("Table #example not found");
                return null;
            }

            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable("#example")) {
                $("#example").DataTable().destroy();
                console.log("Existing DataTable destroyed");
            }

            // Initialize new DataTable
            courseTable = $("#example").DataTable(dataTableConfig);
            console.log("DataTable initialized successfully");

            return courseTable;
        } catch (error) {
            console.error("Error initializing DataTable:", error);
            return null;
        }
    }

    // Initialize the table
    const table = initCourseTable();

    if (!table) {
        console.error("Failed to initialize DataTable");
        return;
    }

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Setup filters with proper event handling
    setupFilters(table);

    // Setup AJAX handlers
    setupAjaxHandlers(table);

    // Cleanup on page unload
    $(window).on("beforeunload", function () {
        if ($.fn.DataTable.isDataTable("#example")) {
            $("#example").DataTable().destroy();
        }
    });
});

// Filter setup function
function setupFilters(table) {
    if (!table) return;

    // Status filter
    $("#statusFilter")
        .off("change")
        .on("change", function () {
            const status = $(this).val();
            if (status === "") {
                table.column(6).search("").draw();
            } else {
                const statusText = status === "1" ? "Aktif" : "Pending";
                table.column(6).search(statusText).draw();
            }
        });

    // Category filter
    $("#categoryFilter")
        .off("change")
        .on("change", function () {
            const category = $(this).val();
            table.column(4).search(category).draw();
        });
}

// AJAX handlers setup
function setupAjaxHandlers(table) {
    if (!table) return;

    // Status toggle
    $(".form-check-input")
        .off("change")
        .on("change", function () {
            const courseId = $(this).data("course-id");
            const status = $(this).is(":checked") ? 1 : 0;
            const switchElement = $(this);

            switchElement.prop("disabled", true);

            $.ajax({
                url: "/admin/course-status",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    course_id: courseId,
                    status: status,
                },
                success: function (response) {
                    if (response.success) {
                        const label = switchElement.next("label").find("small");
                        label.text(status === 1 ? "Aktif" : "Pending");

                        // Show success notification
                        if (typeof Swal !== "undefined") {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    } else {
                        switchElement.prop("checked", !status);
                        if (typeof Swal !== "undefined") {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "error",
                                title: "Error: " + response.message,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    }
                },
                error: function (xhr, status, error) {
                    switchElement.prop("checked", !status);
                    console.error("AJAX Error:", error);

                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: "Terjadi kesalahan saat memperbarui status.",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                },
                complete: function () {
                    switchElement.prop("disabled", false);
                },
            });
        });

    // Delete functionality
    $(".delete-btn")
        .off("click")
        .on("click", function () {
            const courseId = $(this).data("course-id");
            const courseName = $(this).data("course-name");
            const row = $(this).closest("tr");

            if (typeof Swal === "undefined") {
                if (
                    confirm(
                        'Apakah Anda yakin ingin menghapus kursus "' +
                            courseName +
                            '"?'
                    )
                ) {
                    deleteCourse(courseId, row, table);
                }
                return;
            }

            Swal.fire({
                title: "Konfirmasi Penghapusan",
                text: `Apakah Anda yakin ingin menghapus kursus "${courseName}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCourse(courseId, row, table);
                }
            });
        });
}

// Delete course function
function deleteCourse(courseId, row, table) {
    $.ajax({
        url: "/admin/course/" + courseId,
        type: "DELETE",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                table.row(row).remove().draw();

                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            } else {
                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Error: " + response.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);

            if (typeof Swal !== "undefined") {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Terjadi kesalahan saat menghapus kursus.",
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        },
    });
}
