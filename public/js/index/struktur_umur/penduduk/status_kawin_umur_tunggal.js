(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(
            document.getElementById("formSearchStatusKawinUmurTunggal")
        );
        const mariageStatus = [
            "kawin_lk",
            "kawin_pr",
            "belum_kawin_lk",
            "belum_kawin_pr",
            "cerai_hidup_lk",
            "cerai_hidup_pr",
            "cerai_mati_lk",
            "cerai_mati_pr",
        ];
        $.ajax({
            url: $("#formSearchStatusKawinUmurTunggal").attr("action"),
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
                setTableKelurahan(response, mariageStatus);
                setTableKecamatan(response, mariageStatus);
                setTableSum(response, mariageStatus);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(
                    `Penduduk Status Kawin Umur Tunggal Tahun ${tahun} - Semester ${semester}`
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

    function setTableKelurahan(response, mariageStatus) {
        // Map the response to the dataSet format dynamically using the mariageStatus array
        let dataSet = response.dataPerkelurahan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama, item.umur];

            // Dynamically add the mariageStatus data based on the mariageStatus array
            mariageStatus.forEach((mariageStatusKey) => {
                row.push(item[mariageStatusKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable("#tableKelurahan")) {
            // If it is, destroy the existing DataTable instance
            $("#tableKelurahan").DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [{ title: "KECAMATAN" }, { title: "KELURAHAN" }, { title: "UMUR"}];

        // Add columns for each mariageStatus key
        mariageStatus.forEach((mariageStatusKey) => {
            columns.push({ title: mariageStatusKey.toUpperCase() }); // Add the mariageStatus key as the column title
        });

        // Initialize DataTable
        let table = $("#tableKelurahan").DataTable({
            data: dataSet,
            columns: columns,
            createdRow: function (row, data, index) {
                $(row).addClass("selected");
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous:
                        '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                },
            },
        });

        // Add row click event
        table.on("click", "tbody tr", function () {
            var $row = table.row(this).nodes().to$();
            $row.toggleClass("selected");
        });

        // Remove 'selected' class from all rows initially
        table.rows().every(function () {
            this.nodes().to$().removeClass("selected");
        });
    }

    function setTableKecamatan(response, mariageStatus) {
        // Map the response to the dataSet format dynamically using the mariageStatus array
        let dataSet = response.dataPerkecamatan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.umur];

            // Dynamically add the mariageStatus data based on the mariageStatus array
            mariageStatus.forEach((mariageStatusKey) => {
                row.push(item[mariageStatusKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable("#tableKecamatan")) {
            // If it is, destroy the existing DataTable instance
            $("#tableKecamatan").DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [{ title: "KECAMATAN" }, {title: "UMUR"}];

        // Add columns for each mariageStatus key
        mariageStatus.forEach((mariageStatusKey) => {
            columns.push({ title: mariageStatusKey.toUpperCase() }); // Add the mariageStatus key as the column title
        });

        // Initialize DataTable
        let table = $("#tableKecamatan").DataTable({
            data: dataSet,
            columns: columns,
            createdRow: function (row, data, index) {
                $(row).addClass("selected");
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous:
                        '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                },
            },
        });

        // Add row click event
        table.on("click", "tbody tr", function () {
            var $row = table.row(this).nodes().to$();
            $row.toggleClass("selected");
        });

        // Remove 'selected' class from all rows initially
        table.rows().every(function () {
            this.nodes().to$().removeClass("selected");
        });
    }
    function setTableSum(response, mariageStatus) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable("#tableSum")) {
            $("#tableSum").DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach((data) => {
            mariageStatus.forEach((mariageStatusKey) => {
                // const mariageStatusName = mariageStatusKey.split('_')[0].charAt(0).toUpperCase() + mariageStatusKey.split('_')[0].slice(1);
                const mariageStatusName = mariageStatusKey
                    .replace(/_/g, " ")
                    .toUpperCase();

                const row = [
                    mariageStatusName, // Agama
                    data.umur,
                    data[`${mariageStatusKey}`] || 0, // Jumlah
                ];
                tableData.push(row);
            });
        });

        $("#tableSum").DataTable({
            data: tableData,
            columns: [
                { title: "Status Kawin" },
                { title: "Umur" },
                { title: "Jumlah" },
            ],
            destroy: true,
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous:
                        '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                },
            },
        });
    }
})(jQuery);
