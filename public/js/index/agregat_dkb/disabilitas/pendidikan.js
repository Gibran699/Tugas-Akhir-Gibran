(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchDisabilitasPendidikan'));
        const education = [
            'tidak_blm_sekolah_l',
            'tidak_blm_sekolah_p',
            'tidak_blm_sekolah_jml',
            'belum_tamat_sd_sederajat_l',
            'belum_tamat_sd_sederajat_p',
            'belum_tamat_sd_sederajat_jml',
            'tamat_sd_sederajat_l',
            'tamat_sd_sederajat_p',
            'tamat_sd_sederajat_jml',
            'sltp_sederajat_l',
            'sltp_sederajat_p',
            'sltp_sederajat_jml',
            'slta_sederajat_l',
            'slta_sederajat_p',
            'slta_sederajat_jml',
            'diploma_i_ii_l',
            'diploma_i_ii_p',
            'diploma_i_ii_jml',
            'akademi_dipl_iii_s_muda_l',
            'akademi_dipl_iii_s_muda_p',
            'akademi_dipl_iii_s_muda_jml',
            'diploma_iv_strata_i_l',
            'diploma_iv_strata_i_p',
            'diploma_iv_strata_i_jml',
            'strata_ii_l',
            'strata_ii_p',
            'strata_ii_jml',
            'strata_iii_l',
            'strata_iii_p',
            'strata_iii_jml',
        ];
        $.ajax({
            url: $('#formSearchDisabilitasPendidikan').attr('action'),
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
                setTableKelurahan(response, education);
                setTableKecamatan(response, education);
                setTableSum(response, education);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Disabilitas Pendidikan Tahun ${tahun} - Semester ${semester}`);
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

    function setTableKelurahan(response, education) {
        // Map the response to the dataSet format dynamically using the education array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama, item.keterangan];

            // Dynamically add the education data based on the education array
            education.forEach(educationKey => {
                row.push(item[educationKey]); // Add the value from the item object
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
            { title: "KETERANGAN" },
        ];

        // Add columns for each education key
        education.forEach(educationKey => {
            columns.push({ title: educationKey.toUpperCase() }); // Add the education key as the column title
        });

        // Initialize DataTable
        let table = $('#tableKelurahan').DataTable({
            data: dataSet,
            columns: columns,
            scrollY: "60vh", // Enable vertical scrolling with a fixed height
            scrollX: true, // Enable horizontal scrolling
            scrollCollapse: true, // Adjust table height dynamically
            fixedHeader: true, // Enable fixed header
            fixedColumns: {
                left: 1, // Fix the first column (KECAMATAN)
            },
            paging: true, // Enable pagination
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
    function setTableKecamatan(response, education) {
        // Map the response to the dataSet format dynamically using the education array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.keterangan];

            // Dynamically add the education data based on the education array
            education.forEach(educationKey => {
                row.push(item[educationKey]); // Add the value from the item object
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
            { title: "KETERANGAN" }
        ];

        // Add columns for each education key
        education.forEach(educationKey => {
            columns.push({ title: educationKey.toUpperCase() }); // Add the education key as the column title
        });

        // Initialize DataTable
        let table = $('#tableKecamatan').DataTable({
            data: dataSet,
            columns: columns,
            scrollY: "60vh", // Enable vertical scrolling with a fixed height
            scrollX: true, // Enable horizontal scrolling
            scrollCollapse: true, // Adjust table height dynamically
            fixedHeader: true, // Enable fixed header
            fixedColumns: {
                left: 1, // Fix the first column (KECAMATAN)
            },
            paging: true, // Enable pagination
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
    function setTableSum(response, education) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable('#tableSum')) {
            $('#tableSum').DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach(data => {
            education.forEach(educationKey => {
                // const educationName = educationKey.split('_')[0].charAt(0).toUpperCase() + educationKey.split('_')[0].slice(1);
                const educationName = educationKey.toUpperCase();

                const row = [
                    educationName, // Agama
                    data.keterangan, // Keterangan
                    data[`${educationKey}`] || 0 // Jumlah
                ];
                tableData.push(row);
            });
        });

        $('#tableSum').DataTable({
            data: tableData,
            columns: [
                { title: "Pendidikan" },
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
})(jQuery);
