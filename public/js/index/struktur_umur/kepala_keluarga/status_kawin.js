(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchKepalaKeluargaStatusKawin'));
        const ageGroup = [
            '00_04_belum_kawin_lk',
        '00_04_belum_kawin_pr',
        '00_04_kawin_lk',
        '00_04_kawin_pr',
        '00_04_cerai_hidup_lk',
        '00_04_cerai_hidup_pr',
        '00_04_cerai_mati_lk',
        '00_04_cerai_mati_pr',
        '05_09_belum_kawin_lk',
        '05_09_belum_kawin_pr',
        '05_09_kawin_lk',
        '05_09_kawin_pr',
        '05_09_cerai_hidup_lk',
        '05_09_cerai_hidup_pr',
        '05_09_cerai_mati_lk',
        '05_09_cerai_mati_pr',
        '10_14_belum_kawin_lk',
        '10_14_belum_kawin_pr',
        '10_14_kawin_lk',
        '10_14_kawin_pr',
        '10_14_cerai_hidup_lk',
        '10_14_cerai_hidup_pr',
        '10_14_cerai_mati_lk',
        '10_14_cerai_mati_pr',
        '15_19_belum_kawin_lk',
        '15_19_belum_kawin_pr',
        '15_19_kawin_lk',
        '15_19_kawin_pr',
        '15_19_cerai_hidup_lk',
        '15_19_cerai_hidup_pr',
        '15_19_cerai_mati_lk',
        '15_19_cerai_mati_pr',
        '20_24_belum_kawin_lk',
        '20_24_belum_kawin_pr',
        '20_24_kawin_lk',
        '20_24_kawin_pr',
        '20_24_cerai_hidup_lk',
        '20_24_cerai_hidup_pr',
        '20_24_cerai_mati_lk',
        '20_24_cerai_mati_pr',
        '25_29_belum_kawin_lk',
        '25_29_belum_kawin_pr',
        '25_29_kawin_lk',
        '25_29_kawin_pr',
        '25_29_cerai_hidup_lk',
        '25_29_cerai_hidup_pr',
        '25_29_cerai_mati_lk',
        '25_29_cerai_mati_pr',
        '30_34_belum_kawin_lk',
        '30_34_belum_kawin_pr',
        '30_34_kawin_lk',
        '30_34_kawin_pr',
        '30_34_cerai_hidup_lk',
        '30_34_cerai_hidup_pr',
        '30_34_cerai_mati_lk',
        '30_34_cerai_mati_pr',
        '35_39_belum_kawin_lk',
        '35_39_belum_kawin_pr',
        '35_39_kawin_lk',
        '35_39_kawin_pr',
        '35_39_cerai_hidup_lk',
        '35_39_cerai_hidup_pr',
        '35_39_cerai_mati_lk',
        '35_39_cerai_mati_pr',
        '40_44_belum_kawin_lk',
        '40_44_belum_kawin_pr',
        '40_44_kawin_lk',
        '40_44_kawin_pr',
        '40_44_cerai_hidup_lk',
        '40_44_cerai_hidup_pr',
        '40_44_cerai_mati_lk',
        '40_44_cerai_mati_pr',
        '45_49_belum_kawin_lk',
        '45_49_belum_kawin_pr',
        '45_49_kawin_lk',
        '45_49_kawin_pr',
        '45_49_cerai_hidup_lk',
        '45_49_cerai_hidup_pr',
        '45_49_cerai_mati_lk',
        '45_49_cerai_mati_pr',
        '50_54_belum_kawin_lk',
        '50_54_belum_kawin_pr',
        '50_54_kawin_lk',
        '50_54_kawin_pr',
        '50_54_cerai_hidup_lk',
        '50_54_cerai_hidup_pr',
        '50_54_cerai_mati_lk',
        '50_54_cerai_mati_pr',
        '55_59_belum_kawin_lk',
        '55_59_belum_kawin_pr',
        '55_59_kawin_lk',
        '55_59_kawin_pr',
        '55_59_cerai_hidup_lk',
        '55_59_cerai_hidup_pr',
        '55_59_cerai_mati_lk',
        '55_59_cerai_mati_pr',
        '60_64_belum_kawin_lk',
        '60_64_belum_kawin_pr',
        '60_64_kawin_lk',
        '60_64_kawin_pr',
        '60_64_cerai_hidup_lk',
        '60_64_cerai_hidup_pr',
        '60_64_cerai_mati_lk',
        '60_64_cerai_mati_pr',
        '65_69_belum_kawin_lk',
        '65_69_belum_kawin_pr',
        '65_69_kawin_lk',
        '65_69_kawin_pr',
        '65_69_cerai_hidup_lk',
        '65_69_cerai_hidup_pr',
        '65_69_cerai_mati_lk',
        '65_69_cerai_mati_pr',
        '70_74_belum_kawin_lk',
        '70_74_belum_kawin_pr',
        '70_74_kawin_lk',
        '70_74_kawin_pr',
        '70_74_cerai_hidup_lk',
        '70_74_cerai_hidup_pr',
        '70_74_cerai_mati_lk',
        '70_74_cerai_mati_pr',
        'lebih_75_belum_kawin_lk',
        'lebih_75_belum_kawin_pr',
        'lebih_75_kawin_lk',
        'lebih_75_kawin_pr',
        'lebih_75_cerai_hidup_lk',
        'lebih_75_cerai_hidup_pr',
        'lebih_75_cerai_mati_lk',
        'lebih_75_cerai_mati_pr',
        ];
        $.ajax({
            url: $('#formSearchKepalaKeluargaStatusKawin').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Harap Tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.fire({
                    type: 'success', // Updated to 'type' for newer SweetAlert versions
                    title: 'Berhasil',
                    text: response.message || 'Pencarian Berhasil!',
                });
                setTableKelurahan(response, ageGroup);
                setTableKecamatan(response, ageGroup);
                setTableSum(response, ageGroup);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Penduduk Kepala Keluarga Status Kawin Kelompok Umur Tahun ${tahun} - Semester ${semester}`);
            },
            error: function (xhr) {
                let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                if (xhr.status === 400 || xhr.status === 404) {
                    errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message;
                }
                Swal.fire({
                    type: 'error', // Updated to 'type' for newer SweetAlert versions
                    title: 'Gagal',
                    text: errorMessage,
                });
            }
        });
    }

    function setTableKelurahan(response, ageGroup) {
        // Map the response to the dataSet format dynamically using the ageGroup array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama];

            // Dynamically add the ageGroup data based on the ageGroup array
            ageGroup.forEach(religionKey => {
                row.push(item[religionKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#tableKelurahan')) {
            // If it is, destroy the existing DataTable instance
            $('#tableKelurahan').DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [
            { title: "KECAMATAN" },
            { title: "KELURAHAN" },
        ];

        // Add columns for each ageGroup key
        ageGroup.forEach(religionKey => {
            columns.push({ title: religionKey.toUpperCase() }); // Add the ageGroup key as the column title
        });

        // Initialize DataTable
        let table = $('#tableKelurahan').DataTable({
            data: dataSet,
            columns: columns,
            createdRow: function (row, data, index) {
                $(row).addClass('selected');
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });

        // Add row click event
        table.on('click', 'tbody tr', function () {
            var $row = table.row(this).nodes().to$();
            $row.toggleClass('selected');
        });

        // Remove 'selected' class from all rows initially
        table.rows().every(function () {
            this.nodes().to$().removeClass('selected');
        });
    }

    function setTableKecamatan(response, ageGroup) {
        // Map the response to the dataSet format dynamically using the ageGroup array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the ageGroup data based on the ageGroup array
            ageGroup.forEach(religionKey => {
                row.push(item[religionKey]); // Add the value from the item object
            });

            return row;
        });

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#tableKecamatan')) {
            // If it is, destroy the existing DataTable instance
            $('#tableKecamatan').DataTable().clear().destroy();
        }

        // Define the columns dynamically
        let columns = [
            { title: "KECAMATAN" },
        ];

        // Add columns for each ageGroup key
        ageGroup.forEach(religionKey => {
            columns.push({ title: religionKey.toUpperCase() }); // Add the ageGroup key as the column title
        });

        // Initialize DataTable
        let table = $('#tableKecamatan').DataTable({
            data: dataSet,
            columns: columns,
            createdRow: function (row, data, index) {
                $(row).addClass('selected');
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });

        // Add row click event
        table.on('click', 'tbody tr', function () {
            var $row = table.row(this).nodes().to$();
            $row.toggleClass('selected');
        });

        // Remove 'selected' class from all rows initially
        table.rows().every(function () {
            this.nodes().to$().removeClass('selected');
        });
    }
    function setTableSum(response, ageGroup) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable('#tableSum')) {
            $('#tableSum').DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach(data => {
            ageGroup.forEach(ageGroupKey => {
                // const ageGroupName = ageGroupKey.split('_')[0].charAt(0).toUpperCase() + ageGroupKey.split('_')[0].slice(1);
                const ageGroupName = ageGroupKey.replace(/_/g, ' ').toUpperCase();

                const row = [
                    ageGroupName, // Agama
                    data[`${ageGroupKey}`] || 0 // Jumlah
                ];
                tableData.push(row);
            });
        });

        $('#tableSum').DataTable({
            data: tableData,
            columns: [
                { title: "Kelompok Umur & Status Kawin" },
                { title: "Jumlah" }
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
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }
})(jQuery);