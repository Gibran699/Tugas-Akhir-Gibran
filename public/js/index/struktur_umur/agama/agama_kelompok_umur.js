(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchStrukturUmurAgamaKelompokAgama'));
        const religious = [
            'islam_lk',
            'islam_pr',
            'islam_jml',
            'katholik_lk',
            'katholik_pr',
            'katholik_jml',
            'kristen_lk',
            'kristen_pr',
            'kristen_jml',
            'hindu_lk',
            'hindu_pr',
            'hindu_jml',
            'budha_lk',
            'budha_pr',
            'budha_jml',
            'konghucu_lk',
            'konghucu_pr',
            'konghucu_jml',
            'kepercayaan_lk',
            'kepercayaan_pr',
            'kepercayaan_jml',
        ];
        $.ajax({
            url: $('#formSearchStrukturUmurAgamaKelompokAgama').attr('action'),
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
                setTableKelurahan(response, religious);
                setTableKecamatan(response, religious);
                setTableSum(response, religious);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Penduduk Agama Tahun ${tahun} - Semester ${semester}`);
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

    function setTableKelurahan(response, religious) {
        // Map the response to the dataSet format dynamically using the religious array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama, item.kelompok_umur];

            // Dynamically add the religious data based on the religious array
            religious.forEach(religionKey => {
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
            { title: "KELOMPOK UMUR" },

        ];

        // Add columns for each religious key
        religious.forEach(religionKey => {
            columns.push({ title: religionKey.toUpperCase() }); // Add the religious key as the column title
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

    function setTableKecamatan(response, religious) {
        // Map the response to the dataSet format dynamically using the religious array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelompok_umur];

            // Dynamically add the religious data based on the religious array
            religious.forEach(religionKey => {
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
            { title: "KELOMPOK UMUR" },
        ];

        // Add columns for each religious key
        religious.forEach(religionKey => {
            columns.push({ title: religionKey.toUpperCase() }); // Add the religious key as the column title
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
    // function setTableSum(response, religious) {
    //     const summedData = response.dataKeseluruhan;

    //     if ($.fn.DataTable.isDataTable('#tableSum')) {
    //         $('#tableSum').DataTable().clear().destroy();
    //     }

    //     const tableData = [];

    //     summedData.forEach(data => {
    //         religious.forEach(religiousKey => {
    //             // const religiousName = religiousKey.split('_')[0].charAt(0).toUpperCase() + religiousKey.split('_')[0].slice(1);
    //             const religiousName = religiousKey.toUpperCase();

    //             const row = [
    //                 religiousName, // Agama
    //                 data.kelompok_umur, // Keterangan
    //                 data[`${religiousKey}`] || 0 // Jumlah
    //             ];
    //             tableData.push(row);
    //         });
    //     });

    //     $('#tableSum').DataTable({
    //         data: tableData,
    //         columns: [
    //             { title: "Agama" },
    //             { title: "Kelompok Umur" },
    //             { title: "Jumlah" }
    //         ],
    //         destroy: true,
    //         responsive: true,
    //         paging: true,
    //         searching: true,
    //         ordering: true,
    //         info: true,
    //         language: {
    //             paginate: {
    //                 next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
    //                 previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
    //             }
    //         }
    //     });
    // }
    function setTableSum(response, religious) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable('#tableSum')) {
            $('#tableSum').DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach(data => {
            religious.forEach(religiousKey => {
                // const religiousName = religiousKey.split('_')[0].charAt(0).toUpperCase() + religiousKey.split('_')[0].slice(1);
                const religiousName = religiousKey.replace(/_/g, ' ').toUpperCase();

                const row = [
                    religiousName, // Agama
                    data.kelompok_umur, // Keterangan
                    data[`${religiousKey}`] || 0 // Jumlah
                ];
                tableData.push(row);
            });
        });

        $('#tableSum').DataTable({
            data: tableData,
            columns: [
                { title: "Keterangan" },
                { title: "Kategori" },
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
        // Add filter functionality
        $('#agamaFilter').on('change', function () {
            const selectedAgama = $(this).val();
            const table = $('#tableSum').DataTable();

            if (selectedAgama) {
                table.column(0).search(selectedAgama).draw(); // Filter by Agama
            } else {
                table.column(0).search('').draw(); // Clear filter
            }
        });
    }
})(jQuery);