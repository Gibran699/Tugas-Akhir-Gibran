(function ($) {
    $(document).ready(function () {
        // Initialize DataTable
        let table = $("#ktpTable").DataTable({
            columns: [
                { data: "date" },
                { data: "date_total" },
                { data: "actions", orderable: false, searchable: false },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous:
                        '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                },
            },
        });
        const jenisData = "7fK97qB2ax";
        const searchUrl = `/json/search-data/${jenisData}`;
        // Submit form via AJAX
        $("#formSearchDataLayananEKTP").on("submit", function (e) {
            e.preventDefault();
            let formData = $(this).serialize(); // Get form data
            $.ajax({
                url: searchUrl,
                method: "POST",
                data: formData,
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Processing...",
                        text: "Harap Tunggu",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
                success: function (response) {
                    Swal.fire({
                        type: "success",
                        title: "Berhasil",
                        text: response.message || "Pencarian Berhasil!",
                    });
                    let dailyData = response.data.daily_data;
                    let tableData = [];

                    Object.keys(dailyData).forEach((date) => {
                        let total = dailyData[date].date_total;
                        tableData.push({
                            date: date,
                            date_total: total,
                            actions: `<button class="btn btn-info btn-sm view-details" data-date="${date}">Details</button>`,
                        });
                    });

                    // Clear & reload DataTable
                    table.clear().rows.add(tableData).draw();
                    //set to H4
                    const overallCount = response.data.overall_total || "N/A";
                    $('#totalKeseluruhan').text(`Total Keseluruhan Cetak KTP Adalah ${overallCount}`)
                },
                error: function (xhr) {
                    Swal.fire({
                        type: "error",
                        title: "Gagal",
                        text: xhr.responseJSON?.message || "Terjadi kesalahan, coba lagi!",
                    });
                }
            });
        });

        // Handle "Details" button click
        $("#ktpTable tbody").on("click", ".view-details", function () {
            let date = $(this).data("date");
            $("#modalDate").text(date);

            $.ajax({
                url: searchUrl,
                method: "POST",
                data: $("#formSearchDataLayananEKTP").serialize(),
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Processing...",
                        text: "Harap Tunggu",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
                success: function (response) {
                    Swal.close(); // Close the loading alert
                    let users = response.data.daily_data[date].users;
                    let total = response.data.daily_data[date].date_total;
                    let detailsTable = $("#detailsTable tbody");
                    detailsTable.empty();

                    users.forEach((user) => {
                        let percentage =
                            ((user.count / total) * 100).toFixed(2) + "%";
                        detailsTable.append(`
                            <tr>
                                <td>${user.username}</td>
                                <td>${user.count}</td>
                                <td>${percentage}</td>
                            </tr>
                        `);
                    });

                    let modal = new bootstrap.Modal(
                        document.getElementById("detailsModal")
                    );
                    modal.show();
                },
                error: function () {
                    Swal.fire({
                        type: "error",
                        title: "Gagal",
                        text: "Gagal mengambil data detail!",
                    });
                }
            });
        });
    });
})(jQuery);
