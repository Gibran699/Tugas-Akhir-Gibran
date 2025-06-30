(function ($) {
    $(document).ready(function () {
        $("#submitSearch").click(function () {
            fetchData();
        });
    });
    function fetchData() {
        var formData = new FormData(
            document.getElementById(
                "formSearchDateRangeAgeDisabilitasPendidikan"
            )
        );
        const disabilities = [
            "fisik_tidak_belum_sekolah_l",
            "fisik_tidak_belum_sekolah_p",
            "fisik_tidak_belum_sekolah_jml",
            "netra_tidak_belum_sekolah_l",
            "netra_tidak_belum_sekolah_p",
            "netra_tidak_belum_sekolah_jml",
            "rungu_tidak_belum_sekolah_l",
            "rungu_tidak_belum_sekolah_p",
            "rungu_tidak_belum_sekolah_jml",
            "mental_jiwa_tidak_belum_sekolah_l",
            "mental_jiwa_tidak_belum_sekolah_p",
            "mental_jiwa_tidak_belum_sekolah_jml",
            "fisik_mental_tidak_belum_sekolah_l",
            "fisik_mental_tidak_belum_sekolah_p",
            "fisik_mental_tidak_belum_sekolah_jml",
            "lainnya_tidak_belum_sekolah_l",
            "lainnya_tidak_belum_sekolah_p",
            "lainnya_tidak_belum_sekolah_jml",
            "fisik_belum_tamat_sd_sederajat_l",
            "fisik_belum_tamat_sd_sederajat_p",
            "fisik_belum_tamat_sd_sederajat_jml",
            "netra_belum_tamat_sd_sederajat_l",
            "netra_belum_tamat_sd_sederajat_p",
            "netra_belum_tamat_sd_sederajat_jml",
            "rungu_belum_tamat_sd_sederajat_l",
            "rungu_belum_tamat_sd_sederajat_p",
            "rungu_belum_tamat_sd_sederajat_jml",
            "mental_jiwa_belum_tamat_sd_sederajat_l",
            "mental_jiwa_belum_tamat_sd_sederajat_p",
            "mental_jiwa_belum_tamat_sd_sederajat_jml",
            "fisik_mental_belum_tamat_sd_sederajat_l",
            "fisik_mental_belum_tamat_sd_sederajat_p",
            "fisik_mental_belum_tamat_sd_sederajat_jml",
            "lainnya_belum_tamat_sd_sederajat_l",
            "lainnya_belum_tamat_sd_sederajat_p",
            "lainnya_belum_tamat_sd_sederajat_jml",
            "fisik_tamat_sd_sederajat_l",
            "fisik_tamat_sd_sederajat_p",
            "fisik_tamat_sd_sederajat_jml",
            "netra_tamat_sd_sederajat_l",
            "netra_tamat_sd_sederajat_p",
            "netra_tamat_sd_sederajat_jml",
            "rungu_tamat_sd_sederajat_l",
            "rungu_tamat_sd_sederajat_p",
            "rungu_tamat_sd_sederajat_jml",
            "mental_jiwa_tamat_sd_sederajat_l",
            "mental_jiwa_tamat_sd_sederajat_p",
            "mental_jiwa_tamat_sd_sederajat_jml",
            "fisik_mental_tamat_sd_sederajat_l",
            "fisik_mental_tamat_sd_sederajat_p",
            "fisik_mental_tamat_sd_sederajat_jml",
            "lainnya_tamat_sd_sederajat_l",
            "lainnya_tamat_sd_sederajat_p",
            "lainnya_tamat_sd_sederajat_jml",
            "fisik_sltp_sederajat_l",
            "fisik_sltp_sederajat_p",
            "fisik_sltp_sederajat_jml",
            "netra_sltp_sederajat_l",
            "netra_sltp_sederajat_p",
            "netra_sltp_sederajat_jml",
            "rungu_sltp_sederajat_l",
            "rungu_sltp_sederajat_p",
            "rungu_sltp_sederajat_jml",
            "mental_jiwa_sltp_sederajat_l",
            "mental_jiwa_sltp_sederajat_p",
            "mental_jiwa_sltp_sederajat_jml",
            "fisik_mental_sltp_sederajat_l",
            "fisik_mental_sltp_sederajat_p",
            "fisik_mental_sltp_sederajat_jml",
            "lainnya_sltp_sederajat_l",
            "lainnya_sltp_sederajat_p",
            "lainnya_sltp_sederajat_jml",
            "fisik_slta_sederajat_l",
            "fisik_slta_sederajat_p",
            "fisik_slta_sederajat_jml",
            "netra_slta_sederajat_l",
            "netra_slta_sederajat_p",
            "netra_slta_sederajat_jml",
            "rungu_slta_sederajat_l",
            "rungu_slta_sederajat_p",
            "rungu_slta_sederajat_jml",
            "mental_slta_sederajat_l",
            "mental_slta_sederajat_p",
            "mental_jiwa_slta_sederajat_jml",
            "fisik_mental_slta_sederajat_l",
            "fisik_mental_slta_sederajat_p",
            "fisik_mental_slta_sederajat_jml",
            "lainnya_slta_sederajat_l",
            "lainnya_slta_sederajat_p",
            "lainnya_slta_sederajat_jml",
            "fisik_diploma_i_ii_l",
            "fisik_diploma_i_ii_p",
            "fisik_diploma_i_ii_jml",
            "netra_diploma_i_ii_l",
            "netra_diploma_i_ii_p",
            "netra_diploma_i_ii_jml",
            "rungu_diploma_i_ii_l",
            "rungu_diploma_i_ii_p",
            "rungu_diploma_i_ii_jml",
            "mental_jiwa_diploma_i_ii_l",
            "mental_jiwa_diploma_i_ii_p",
            "mental_jiwa_diploma_i_ii_jml",
            "fisik_mental_diploma_i_ii_l",
            "fisik_mental_diploma_i_ii_p",
            "fisik_mental_diploma_i_ii_jml",
            "lainnya_diploma_i_ii_l",
            "lainnya_diploma_i_ii_p",
            "lainnya_diploma_i_ii_jml",
            "fisik_akademi_diploma_iii_s_muda_l",
            "fisik_akademi_diploma_iii_s_muda_p",
            "fisik_akademi_diploma_iii_s_muda_jml",
            "netra_akademi_diploma_iii_s_muda_l",
            "netra_akademi_diploma_iii_s_muda_p",
            "netra_akademi_diploma_iii_s_muda_jml",
            "rungu_akademi_diploma_iii_s_muda_l",
            "rungu_akademi_diploma_iii_s_muda_p",
            "rungu_akademi_diploma_iii_s_muda_jml",
            "mental_jiwa_akademi_diploma_iii_s_muda_l",
            "mental_jiwa_akademi_diploma_iii_s_muda_p",
            "mental_jiwa_akademi_diploma_iii_s_muda_jml",
            "fisik_mental_akademi_diploma_iii_s_muda_l",
            "fisik_mental_akademi_diploma_iii_s_muda_p",
            "fisik_mental_akademi_diploma_iii_s_muda_jml",
            "lainnya_akademi_diploma_iii_s_muda_l",
            "lainnya_akademi_diploma_iii_s_muda_p",
            "lainnya_akademi_diploma_iii_s_muda_jml",
            "fisik_diploma_iv_l",
            "fisik_diploma_iv_p",
            "fisik_diploma_iv_jml",
            "netra_diploma_iv_l",
            "netra_diploma_iv_p",
            "netra_diploma_iv_jml",
            "rungu_diploma_iv_l",
            "rungu_diploma_iv_p",
            "rungu_diploma_iv_jml",
            "mental_jiwa_diploma_iv_l",
            "mental_jiwa_diploma_iv_p",
            "mental_jiwa_diploma_iv_jml",
            "fisik_mental_diploma_iv_l",
            "fisik_mental_diploma_iv_p",
            "fisik_mental_diploma_iv_jml",
            "lainnya_diploma_iv_l",
            "lainnya_diploma_iv_p",
            "lainnya_diploma_iv_jml",
            "fisik_strata_ii_l",
            "fisik_strata_ii_p",
            "fisik_strata_ii_jml",
            "netra_strata_ii_l",
            "netra_strata_ii_p",
            "netra_strata_ii_jml",
            "rungu_strata_ii_l",
            "rungu_strata_ii_p",
            "rungu_strata_ii_jml",
            "mental_jiwa_strata_ii_l",
            "mental_jiwa_strata_ii_p",
            "mental_jiwa_strata_ii_jml",
            "fisik_mental_strata_ii_l",
            "fisik_mental_strata_ii_p",
            "fisik_mental_strata_ii_jml",
            "lainnya_strata_ii_l",
            "lainnya_strata_ii_p",
            "lainnya_strata_ii_jml",
            "fisik_strata_iii_l",
            "fisik_strata_iii_p",
            "fisik_strata_iii_jml",
            "netra_strata_iii_l",
            "netra_strata_iii_p",
            "netra_strata_iii_jml",
            "rungu_strata_iii_l",
            "rungu_strata_iii_p",
            "rungu_strata_iii_jml",
            "mental_jiwa_strata_iii_l",
            "mental_jiwa_strata_iii_p",
            "mental_jiwa_strata_iii_jml",
            "fisik_mental_strata_iii_l",
            "fisik_mental_strata_iii_p",
            "fisik_mental_strata_iii_jml",
            "lainnya_strata_iii_l",
            "lainnya_strata_iii_p",
            "lainnya_strata_iii_jml",
        ];
        $.ajax({
            url: $("#formSearchDateRangeAgeDisabilitasPendidikan").attr(
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
                    `${kelompokUmur}  Disabilitas Pendidikan  Tahun ${tahun} - Semester ${semester}`
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
                { title: "Pendidikan & Disabilitas" },
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
