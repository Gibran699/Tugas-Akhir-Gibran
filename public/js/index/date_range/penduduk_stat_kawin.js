(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });
    function fetchData() {
        var formData = new FormData(
            document.getElementById(
                "formSearchDateRangePendudukStatKawin"
            )
        );
        const disabilities = [
            'belum_kawin_lk',
            'belum_kawin_pr',
            'belum_kawin_jml',
            'kawin_lk',
            'kawin_pr',
            'kawin_jml',
            'cerai_hidup_lk',
            'cerai_hidup_pr',
            'cerai_hidup_jml',
            'cerai_mati_lk',
            'cerai_mati_pr',
            'cerai_mati_jml',
        ];
        $.ajax({
            url: $("#formSearchDateRangePendudukStatKawin").attr(
                "action"
            ),
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
                setTableKelurahan(response, disabilities);
                setTableKecamatan(response, disabilities);
                setTableSum(response, disabilities);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                const kelompokUmur = response.dataTitle.title || "N/A";
                $("#title").text(
                    `${kelompokUmur}  Penduduk Status Kawin Tahun ${tahun} - Semester ${semester}`
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

    function setTableKelurahan(response, disabilities) {
        // Map the response to the dataSet format dynamically using the disabilities array
        let dataSet = response.dataPerkelurahan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [
                item.kecamatan_nama,
                item.kelurahan_nama,
            ];

            // Dynamically add the disabilities data based on the disabilities array
            disabilities.forEach((religionKey) => {
                row.push(item[religionKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable("#tableKelurahan")) {
            // If it is, destroy the existing DataTable instance
            $("#tableKelurahan").DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [
            { title: "KECAMATAN" },
            { title: "KELURAHAN" },
        ];

        // Add columns for each disabilities key
        disabilities.forEach((religionKey) => {
            columns.push({ title: religionKey.toUpperCase() }); // Add the disabilities key as the column title
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
    function setTableKecamatan(response, disabilities) {
        // Map the response to the dataSet format dynamically using the disabilities array
        let dataSet = response.dataPerkecamatan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the disabilities data based on the disabilities array
            disabilities.forEach((religionKey) => {
                row.push(item[religionKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable("#tableKecamatan")) {
            // If it is, destroy the existing DataTable instance
            $("#tableKecamatan").DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [{ title: "KECAMATAN" }];

        // Add columns for each disabilities key
        disabilities.forEach((religionKey) => {
            columns.push({ title: religionKey.toUpperCase() }); // Add the disabilities key as the column title
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
    function setTableSum(response, disabilities) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable("#tableSum")) {
            $("#tableSum").DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach((data) => {
            disabilities.forEach((disabilitiesKey) => {
                // const keterangan = disabilitiesKey.split('_')[0].charAt(0).toUpperCase() + disabilitiesKey.split('_')[0].slice(1);
                const keterangan = disabilitiesKey
                    .replace(/_/g, " ")
                    .toUpperCase();

                const row = [
                    keterangan, // Agama
                    data[`${disabilitiesKey}`] || 0, // Jumlah
                ];
                tableData.push(row);
            });
        });

        $("#tableSum").DataTable({
            data: tableData,
            columns: [
                { title: "Keterangan" },
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
        // Add filter functionality for education level
        $("#educationFilter").on("change", function () {
            const selectedEducation = $(this).val();
            const table = $("#tableSum").DataTable();

            if (selectedEducation) {
                table.column(0).search(selectedEducation).draw(); // Filter by Education Level
            } else {
                table.column(0).search("").draw(); // Clear filter
            }
        });
    }
})(jQuery);
