(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(
            document.getElementById("formSearchDataLayananCapil")
        );
        const serviceName = [
            "cetak_akta_kelahiran_lk",
            "cetak_akta_kelahiran_pr",
            "cetak_akta_kelahiran_jml",
            "pembatalan_kelahiran",
            "pembetulan_kelahiran",
            "cetak_akta_kematian_lk",
            "cetak_akta_kematian_pr",
            "cetak_akta_kematian_jml",
            "cetak_akta_kawin",
            "pembatalan_akta_kawin",
            "cetak_akta_cerai",
            "pembatalan_akta_cerai",
            "perubahan_wni_wna",
            "perubahan_wna_wni",
            "perubahan_nama",
            "perubahan_jenis_kelamin",
            "pengesahan_anak_lk",
            "pengesahan_anak_pr",
            "pengesahan_anak_jml",
            "pengangkatan_anak_lk",
            "pengangkatan_anak_pr",
            "pengangkatan_anak_jml",
        ];
        $.ajax({
            url: $("#formSearchDataLayananCapil").attr("action"),
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
                Swal.close();
                if (typeof window.hideLoading === 'function') window.hideLoading();
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: response.message || "Pencarian Berhasil!",
                });
                setTableKelurahan(response, serviceName);
                setTableKecamatan(response, serviceName);
                setTableSum(response, serviceName);
                // Set the value of #tahunSemester dynamically
                const dari = response.dataTitle.dari || "N/A";
                const sampai = response.dataTitle.sampai || "N/A";
                $("#tahunSemester").text(
                    `Laporan Kinerja Capil ${dari} -  ${sampai}`
                );
            },
            error: function (xhr) {
                if (typeof window.hideLoading === 'function') window.hideLoading();
                let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";
                if (xhr.status === 400 || xhr.status === 404) {
                    errorMessage =
                        xhr.responseJSON?.data || xhr.responseJSON?.message;
                }
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: errorMessage,
                });
            },
            complete: function () {
                if (typeof window.hideLoading === 'function') window.hideLoading();
            },
        });
    }

    function setTableKelurahan(response, serviceName) {
        // Map the response to the dataSet format dynamically using the serviceName array
        let dataSet = response.dataPerkelurahan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [
                item.kecamatan_nama,
                item.kelurahan_nama,
            ];

            // Dynamically add the serviceName data based on the serviceName array
            serviceName.forEach((serviceNameKey) => {
                row.push(item[serviceNameKey]); // Add the value from the item object
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

        // Add columns for each serviceName key
        serviceName.forEach((serviceNameKey) => {
            columns.push({ title: serviceNameKey.toUpperCase() }); // Add the serviceName key as the column title
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

    function setTableKecamatan(response, serviceName) {
        // Map the response to the dataSet format dynamically using the serviceName array
        let dataSet = response.dataPerkecamatan.map((item) => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the serviceName data based on the serviceName array
            serviceName.forEach((serviceNameKey) => {
                row.push(item[serviceNameKey]); // Add the value from the item object
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

        // Add columns for each serviceName key
        serviceName.forEach((serviceNameKey) => {
            columns.push({ title: serviceNameKey.toUpperCase() }); // Add the serviceName key as the column title
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
    function setTableSum(response, serviceName) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable("#tableSum")) {
            $("#tableSum").DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach((data) => {
            serviceName.forEach((serviceNameKey) => {
                // const serviceNameName = serviceNameKey.split('_')[0].charAt(0).toUpperCase() + serviceNameKey.split('_')[0].slice(1);
                const serviceNameName = serviceNameKey.toUpperCase();

                const row = [
                    serviceNameName, // Agama
                    data[`${serviceNameKey}`] || 0, // Jumlah
                ];
                tableData.push(row);
            });
        });

        $("#tableSum").DataTable({
            data: tableData,
            columns: [
                { title: "Layanan" },
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
