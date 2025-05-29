(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchPendidikanJenisKelamin'));
        const educations = [
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
            url: $('#formSearchPendidikanJenisKelamin').attr('action'),
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
                setTableKelurahan(response, educations);
                setTableKecamatan(response, educations);
                setTableSum(response, educations);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Status Kawin Jenis Kelamin Tahun ${tahun} - Semester ${semester}`);
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

    function setTableKelurahan(response, educations) {
        // Map the response to the dataSet format dynamically using the educations array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama];

            // Dynamically add the educations data based on the educations array
            educations.forEach(educationsKey => {
                row.push(item[educationsKey]); // Add the value from the item object
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
            { title: "KELURAHAN" }
        ];

        // Add columns for each educations key
        educations.forEach(educationsKey => {
            columns.push({ title: educationsKey.toUpperCase() }); // Add the educations key as the column title
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

    function setTableKecamatan(response, educations) {
        // Map the response to the dataSet format dynamically using the educations array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the educations data based on the educations array
            educations.forEach(educationsKey => {
                row.push(item[educationsKey]); // Add the value from the item object
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
            { title: "KECAMATAN" }
        ];

        // Add columns for each educations key
        educations.forEach(educationsKey => {
            columns.push({ title: educationsKey.toUpperCase() }); // Add the educations key as the column title
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
    function setTableSum(response, educations) {
        // Extract the summed data from the response
        const summedData = response.dataKeseluruhan;

        // Clear the table body before populating
        $('#tableSum tbody').empty();

        // Iterate over the educations array to dynamically generate rows
        educations.forEach(educationsKey => {
            // Extract the educations name from the key (e.g., "islam_lk" -> "Islam")
            const educationsName = educationsKey.replace(/_(l|p|jml)$/, '').toUpperCase();
            // Check if the educations name already exists in the table
            const existingRow = $(`#tableSum tbody tr:contains("${educationsName}")`);
            if (existingRow.length > 0) {
                // If the row already exists, update the values
                const row = existingRow[0];
                const cellType = educationsKey.split('_')[1]; // e.g., "lk", "pr", "jml"
                if (cellType === 'l') {
                    $(row).find('td:eq(1)').text(summedData[educationsKey]); // Update Laki-Laki
                } else if (cellType === 'p') {
                    $(row).find('td:eq(2)').text(summedData[educationsKey]); // Update Perempuan
                } else if (cellType === 'jml') {
                    $(row).find('td:eq(3)').text(summedData[educationsKey]); // Update jml
                }
            } else {
                // If the row does not exist, create a new row
                const row = `
                    <tr>
                        <td>${educationsName}</td>
                        <td>${summedData[`${educationsName.toLowerCase()}_l`] || 0}</td>
                        <td>${summedData[`${educationsName.toLowerCase()}_p`] || 0}</td>
                        <td>${summedData[`${educationsName.toLowerCase()}_jml`] || 0}</td>
                    </tr>
                `;
                $('#tableSum tbody').append(row);
            }
        });
    }
})(jQuery);