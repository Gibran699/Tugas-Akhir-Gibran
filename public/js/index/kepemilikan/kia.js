(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchKepemilikanKia'));
        const category = [
            'persen_awal',
            'persen_dinamis',
            'jumlah_awal_lk',
            'jumlah_awal_pr',
            'jumlah_awal_jml',
            'memiliki_awal_lk',
            'memiliki_awal_pr',
            'memiliki_awal_jml',
            'belum_memiliki_awal_lk',
            'belum_memiliki_awal_pr',
            'belum_memiliki_awal_jml',
            'usia_lebih_target_lk',
            'usia_lebih_target_pr',
            'usia_lebih_target_jml',
            'meninggal_lk',
            'meninggal_pr',
            'meninggal_jml',
            'nonaktif_lk',
            'nonaktif_pr',
            'nonaktif_jml',
            'memiliki_dalam_dkb_lk',
            'memiliki_dalam_dkb_pr',
            'memiliki_dalam_dkb_jml',
            'memiliki_luar_dkb_lk',
            'memiliki_luar_dkb_pr',
            'memiliki_luar_dkb_jml',
            'jumlah_dinamis_lk',
            'jumlah_dinamis_pr',
            'jumlah_dinamis_ttl',
            'memiliki_dinamis_lk',
            'memiliki_dinamis_pr',
            'memiliki_dinamis_jml',
            'belum_memiliki_dinamis_lk',
            'belum_memiliki_dinamis_pr',
            'belum_memiliki_dinamis_jml',
            'penambahan_lk',
            'penambahan_pr',
            'penambahan_jml',
        ];
        $.ajax({
            url: $('#formSearchKepemilikanKia').attr('action'),
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
                setTableSum(response, category);
                setTableKecamatan(response, category);
                setTableKelurahan(response, category);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Kepemilikan KIA Tahun ${tahun} - Semester ${semester}`);
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
    function setTableSum(response, category) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable('#tableSum')) {
            $('#tableSum').DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach(data => {
            category.forEach(categoryKey => {
                // const categoryName = categoryKey.split('_')[0].charAt(0).toUpperCase() + categoryKey.split('_')[0].slice(1);
                const categoryName = categoryKey.replace(/_/g, ' ').toUpperCase();

                const row = [
                    categoryName, // Agama
                    data[`${categoryKey}`] || 0 // Jumlah
                ];
                tableData.push(row);
            });
        });

        $('#tableSum').DataTable({
            data: tableData,
            columns: [
                { title: "Keterangan" },
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
    function setTableKecamatan(response, category) {
        // Map the response to the dataSet format dynamically using the category array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the category data based on the category array
            category.forEach(categoryKey => {
                row.push(item[categoryKey]); // Add the value from the item object
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

        // Add columns for each category key
        category.forEach(categoryKey => {
            columns.push({ title: categoryKey.toUpperCase() }); // Add the category key as the column title
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
    function setTableKelurahan(response, category) {
        // Map the response to the dataSet format dynamically using the category array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama];

            // Dynamically add the category data based on the category array
            category.forEach(categoryKey => {
                row.push(item[categoryKey]); // Add the value from the item object
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

        // Add columns for each category key
        category.forEach(categoryKey => {
            columns.push({ title: categoryKey.toUpperCase() }); // Add the category key as the column title
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
})(jQuery);