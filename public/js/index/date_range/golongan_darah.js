(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });
    function fetchData() {
        var formData = new FormData(
            document.getElementById(
                "formSearchDateRangeAgeBloodType"
            )
        );
        const disabilities = [
            'a_lk',
            'a_pr',
            'a_jml',
            'a_m_lk',
            'a_m_pr',
            'a_m_jml',
            'a_p_lk',
            'a_p_pr',
            'a_p_jml',
            'b_lk',
            'b_pr',
            'b_jml',
            'b_m_lk',
            'b_m_pr',
            'b_m_jml',
            'b_p_lk',
            'b_p_pr',
            'b_p_jml',
            'ab_lk',
            'ab_pr',
            'ab_jml',
            'ab_m_lk',
            'ab_m_pr',
            'ab_m_jml',
            'ab_p_lk',
            'ab_p_pr',
            'ab_p_jml',
            'o_lk',
            'o_pr',
            'o_jml',
            'o_m_lk',
            'o_m_pr',
            'o_m_jml',
            'o_p_lk',
            'o_p_pr',
            'o_p_jml',
            'tidak_tahu_lk',
            'tidak_tahu_pr',
            'tidak_tahu_jml',
        ];
        $.ajax({
            url: $("#formSearchDateRangeAgeBloodType").attr(
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
                    `${kelompokUmur}  Golongan Darah Tahun ${tahun} - Semester ${semester}`
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
                // const disabilitiesName = disabilitiesKey.split('_')[0].charAt(0).toUpperCase() + disabilitiesKey.split('_')[0].slice(1);
                const disabilitiesName = disabilitiesKey
                    .replace(/_/g, " ")
                    .toUpperCase();

                const row = [
                    disabilitiesName, // Agama
                    data[`${disabilitiesKey}`] || 0, // Jumlah
                ];
                tableData.push(row);
            });
        });

        $("#tableSum").DataTable({
            data: tableData,
            columns: [
                { title: "Golongan Darah" },
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
