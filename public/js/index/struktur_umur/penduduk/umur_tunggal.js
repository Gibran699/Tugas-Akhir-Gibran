(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(
            document.getElementById("formSearchPendudukUmurTunggal")
        );
        const atributTable = ["lk", "pr", "jumlah"];
        $.ajax({
            url: $("#formSearchPendudukUmurTunggal").attr("action"),
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
                setTableKelurahan(response, atributTable);
                setTableKecamatan(response, atributTable);
                setTableSum(response, atributTable);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(
                    `Penduduk Jenis Kelamin Umur Tunggal Tahun ${tahun} - Semester ${semester}`
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

    function setTableKelurahan(response, atributTable) {
        // Map the response to the dataSet format dynamically using the atributTable array
        let dataSet = response.dataPerkelurahan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama, item.umur];

            // Dynamically add the atributTable data based on the atributTable array
            atributTable.forEach((atributTableKey) => {
                row.push(item[atributTableKey]); // Add the value from the item object
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
            { title: "UMUR" },
        ];

        // Add columns for each atributTable key
        atributTable.forEach((atributTableKey) => {
            columns.push({ title: atributTableKey.toUpperCase() }); // Add the atributTable key as the column title
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

    function setTableKecamatan(response, atributTable) {
        // Map the response to the dataSet format dynamically using the atributTable array
        let dataSet = response.dataPerkecamatan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.umur];

            // Dynamically add the atributTable data based on the atributTable array
            atributTable.forEach((atributTableKey) => {
                row.push(item[atributTableKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable("#tableKecamatan")) {
            // If it is, destroy the existing DataTable instance
            $("#tableKecamatan").DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [{ title: "KECAMATAN" }, { title: "UMUR" }];

        // Add columns for each atributTable key
        atributTable.forEach((atributTableKey) => {
            columns.push({ title: atributTableKey.toUpperCase() }); // Add the atributTable key as the column title
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
    function setTableSum(response, atributTable) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable("#tableSum")) {
            $("#tableSum").DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach((data) => {
            atributTable.forEach((atributTableKey) => {
                // const atributTableName = atributTableKey.split('_')[0].charAt(0).toUpperCase() + atributTableKey.split('_')[0].slice(1);
                const atributTableName = atributTableKey
                    .replace(/_/g, " ")
                    .toUpperCase();

                const row = [
                    atributTableName, // Agama
                    data.umur, // Keterangan
                    data[`${atributTableKey}`] || 0, // Jumlah
                ];
                tableData.push(row);
            });
        });

        $("#tableSum").DataTable({
            data: tableData,
            columns: [
                { title: "Keterangan" },
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
