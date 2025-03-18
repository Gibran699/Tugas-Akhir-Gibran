(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(
            document.getElementById("formSearchDisabilitasUsiaSekolah")
        );
        const disabilities = [
            "fisik_u4_6th_lk",
            "fisik_u4_6th_pr",
            "fisik_u7_12th_lk",
            "fisik_u7_12th_pr",
            "fisik_u13_15th_lk",
            "fisik_u13_15th_pr",
            "fisik_u16_18th_lk",
            "fisik_u16_18th_pr",
            "netra_buta_u4_6th_lk",
            "netra_buta_u4_6th_pr",
            "netra_buta_u7_12th_lk",
            "netra_buta_u7_12th_pr",
            "netra_buta_u13_15th_lk",
            "netra_buta_u13_15th_pr",
            "netra_buta_u16_18th_lk",
            "netra_buta_u16_18th_pr",
            "rungu_wicara_u4_6th_lk",
            "rungu_wicara_u4_6th_pr",
            "rungu_wicara_u7_12th_lk",
            "rungu_wicara_u7_12th_pr",
            "rungu_wicara_u13_15th_lk",
            "rungu_wicara_u13_15th_pr",
            "rungu_wicara_u16_18th_lk",
            "rungu_wicara_u16_18th_pr",
            "mental_jiwa_u4_6th_lk",
            "mental_jiwa_u4_6th_pr",
            "mental_jiwa_u7_12th_lk",
            "mental_jiwa_u7_12th_pr",
            "mental_jiwa_u13_15th_lk",
            "mental_jiwa_u13_15th_pr",
            "mental_jiwa_u16_18th_lk",
            "mental_jiwa_u16_18th_pr",
            "fisik_mental_u4_6th_lk",
            "fisik_mental_u4_6th_pr",
            "fisik_mental_u7_12th_lk",
            "fisik_mental_u7_12th_pr",
            "fisik_mental_u13_15th_lk",
            "fisik_mental_u13_15th_pr",
            "fisik_mental_u16_18th_lk",
            "fisik_mental_u16_18th_pr",
            "lainnya_u4_6th_lk",
            "lainnya_u4_6th_pr",
            "lainnya_u7_12th_lk",
            "lainnya_u7_12th_pr",
            "lainnya_u13_15th_lk",
            "lainnya_u13_15th_pr",
            "lainnya_u16_18th_lk",
            "lainnya_u16_18th_pr",
        ];
        $.ajax({
            url: $("#formSearchDisabilitasUsiaSekolah").attr("action"),
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
                $("#tahunSemester").text(
                    `Penduduk Disabilitas Usia Sekolaj Tahun ${tahun} - Semester ${semester}`
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
        // Add filter functionality
        // $("#disabilitasFilter").on("change", function () {
        //     const selectedDisabilitas = $(this).val();
        //     const table = $("#tableSum").DataTable();

        //     if (selectedDisabilitas) {
        //         table.column(0).search(selectedDisabilitas).draw(); // Filter by Agama
        //     } else {
        //         table.column(0).search("").draw(); // Clear filter
        //     }
        // });
    }
})(jQuery);
