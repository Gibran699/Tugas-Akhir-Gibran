(function ($) {
    $(document).ready(function () {
        // Initialize DataTable
        let table = $("#rekamTable").DataTable({
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

        const jenisData = "7x9Fk2pQ8R";
        const searchUrl = `/json/search-data/${jenisData}`;

        // Cache last response so Details button never re-fetches
        let cachedDailyData = {};

        // Submit form via AJAX
        $("#formSearchDataLayananPerekaman").on("submit", function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: searchUrl,
                method: "POST",
                data: formData,
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Memproses...",
                        text: "Harap Tunggu",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
                success: function (response) {
                    Swal.close(); // Always close loading first
                    if (typeof window.hideLoading === 'function') window.hideLoading();

                    let dailyData = response.data.daily_data;
                    cachedDailyData = dailyData; // Cache for detail lookups

                    let tableData = [];
                    Object.keys(dailyData).forEach((date) => {
                        let total = dailyData[date].date_total;
                        tableData.push({
                            date: date,
                            date_total: total,
                            actions: `<button class="btn btn-info btn-sm view-details" data-date="${date}"><i class="fas fa-eye me-1"></i>Detail</button>`,
                        });
                    });

                    const overallCount = response.data.overall_total || "N/A";
                    $('#totalKeseluruhan').text(`Total Keseluruhan Perekaman: ${overallCount}`);
                    table.clear().rows.add(tableData).draw();
                },
                error: function (xhr) {
                    if (typeof window.hideLoading === 'function') window.hideLoading();
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: xhr.responseJSON?.message || "Terjadi kesalahan, coba lagi!",
                    });
                },
                complete: function () {
                    if (typeof window.hideLoading === 'function') window.hideLoading();
                }
            });
        });

        // Handle "Details" button click — use cached data, no extra AJAX
        $("#rekamTable tbody").on("click", ".view-details", function () {
            let date = $(this).data("date");

            if (!cachedDailyData[date]) {
                Swal.fire({
                    icon: "warning",
                    title: "Data tidak tersedia",
                    text: "Silakan lakukan pencarian terlebih dahulu.",
                });
                return;
            }

            $("#modalDate").text(date);

            let users = cachedDailyData[date].users || [];
            let total = cachedDailyData[date].date_total || 0;
            let detailsTable = $("#detailsTable tbody");
            detailsTable.empty();

            if (users.length === 0) {
                detailsTable.append(`<tr><td colspan="3" class="text-center text-muted">Tidak ada data petugas.</td></tr>`);
            } else {
                users.forEach((user) => {
                    const pctStr = (total > 0
                        ? ((user.count / total) * 100).toFixed(2)
                        : '0.00') + '%';
                    const pctPadded = pctStr.padStart(7);
                    detailsTable.append(`
                        <tr>
                            <td>${user.username}</td>
                            <td>${user.count}</td>
                            <td><code class="pct-cell">${pctPadded}</code></td>
                        </tr>
                    `);
                });
            }

            let modal = new bootstrap.Modal(document.getElementById("detailsModal"));
            modal.show();
        });
    });
})(jQuery);
