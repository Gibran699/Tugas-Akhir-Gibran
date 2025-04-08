(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });
    function fetchData() {
        var formData = new FormData(
            document.getElementById("formSearchDataLayananOnline")
        );
        $.ajax({
            url: $("#formSearchDataLayananOnline").attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
                    type: "success", // Updated to 'type' for newer SweetAlert versions
                    title: "Berhasil",
                    text: response.message || "Pencarian Berhasil!",
                });
                updateCardData(response);
                updateTableRincian(response);
                // Set the value of #tanggalRequest dynamically
                const dari = formatDate(response.date.start) || "N/A";
                const sampai = formatDate(response.date.finish) || "N/A";
                $("#tanggalRequest").text(
                    `Laporan Pelayanan Online ${dari} - ${sampai}`
                );
            },
            error: function (xhr) {
                let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";

                if (xhr.status === 400 || xhr.status === 404) {
                    errorMessage =
                        xhr.responseJSON?.data || xhr.responseJSON?.message;
                }
                Swal.fire({
                    type: "error", // Updated to 'type' for newer SweetAlert versions
                    title: "Gagal",
                    text: errorMessage,
                });
            },
        });
    }
    function updateCardData(response) {
        $('#submissionCard').text(response.aktaKematian.permohonan + response.aktaKelahiranMerge.permohonan +
            response.pindahDatang.permohonan + response.pindahKeluar.permohonan + response.kia.permohonan +
            response.ktp.permohonan + response.kkMerge.permohonan);
        $('#prosesCard').text(response.aktaKematian.proses + response.aktaKelahiranMerge.proses + response
            .pindahDatang.proses + response.pindahKeluar.proses + response.kia.proses + response.ktp
            .proses + response.kkMerge.proses);
        $('#selesaiCard').text(response.aktaKematian.selesai + response.aktaKelahiranMerge.selesai + response
            .pindahDatang.selesai + response.pindahKeluar.selesai + response.kia.selesai + response.ktp
            .selesai + response.kkMerge.selesai);
        $('#tidakSesuaiCard').text(response.aktaKematian.tidak_sesuai + response.aktaKelahiranMerge
            .tidak_sesuai + response.pindahDatang.tidak_sesuai + response.pindahKeluar.tidak_sesuai +
            response.kia.tidak_sesuai + response.ktp.tidak_sesuai + response.kkMerge.tidak_sesuai);
    }
    function updateTableRincian(response) {
        var tbody = $("#tableLayananOnline tbody");
        // Clear existing rows if needed
        tbody.empty();
        // Iterate through dataArray and build rows
        response.dataTable.forEach(function (response) {
            var row =
                "<tr>" +
                '<td class="text-left">' +
                response.nama_layanan +
                "</td>" +
                "<td>" +
                response.permohonan +
                "</td>" +
                "<td>" +
                response.validasi +
                "</td>" +
                "<td>" +
                response.proses +
                "</td>" +
                "<td>" +
                response.selesai +
                "</td>" +
                "<td>" +
                response.tidak_sesuai +
                "</td>" +
                "</tr>";

            // Append row to tbody
            tbody.append(row);
        });
    }
    function formatDate(dateString) {
        if (!dateString || dateString === "N/A") return "N/A";

        const date = new Date(dateString);
        if (isNaN(date.getTime())) return "N/A"; // Invalid date check

        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are 0-based
        const year = date.getFullYear();

        return `${day}/${month}/${year}`;
    }
})(jQuery);
