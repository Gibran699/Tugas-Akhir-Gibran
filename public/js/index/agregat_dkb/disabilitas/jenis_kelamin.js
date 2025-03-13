(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchDisabilitasJenisKelamin'));
        const disabilites = [
            'disabiltas_fisik_lk',
            'disabiltas_fisik_pr',
            'disabiltas_fisik_jml',
            'disabiltas_netra_buta_lk',
            'disabiltas_netra_buta_pr',
            'disabiltas_netra_buta_jml',
            'disabiltas_rungu_wicara_lk',
            'disabiltas_rungu_wicara_pr',
            'disabiltas_rungu_wicara_jml',
            'disabiltas_mental_jiwa_lk',
            'disabiltas_mental_jiwa_pr',
            'disabiltas_mental_jiwa_jml',
            'disabiltas_fisik_mental_lk',
            'disabiltas_fisik_mental_pr',
            'disabiltas_fisik_mental_jml',
            'disabiltas_lainya_lk',
            'disabiltas_lainya_pr',
            'disabiltas_lainya_jml',
        ];
        $.ajax({
            url: $('#formSearchDisabilitasJenisKelamin').attr('action'),
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
                setTableKelurahan(response, disabilites);
                setTableKecamatan(response, disabilites);
                setTableSum(response, disabilites);
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

    function setTableKelurahan(response, disabilites) {
        // Map the response to the dataSet format dynamically using the disabilites array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama];

            // Dynamically add the disabilites data based on the disabilites array
            disabilites.forEach(disabilitesKey => {
                row.push(item[disabilitesKey]); // Add the value from the item object
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

        // Add columns for each disabilites key
        disabilites.forEach(disabilitesKey => {
            columns.push({ title: disabilitesKey.toUpperCase() }); // Add the disabilites key as the column title
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

    function setTableKecamatan(response, disabilites) {
        // Map the response to the dataSet format dynamically using the disabilites array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the disabilites data based on the disabilites array
            disabilites.forEach(disabilitesKey => {
                row.push(item[disabilitesKey]); // Add the value from the item object
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

        // Add columns for each disabilites key
        disabilites.forEach(disabilitesKey => {
            columns.push({ title: disabilitesKey.toUpperCase() }); // Add the disabilites key as the column title
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
    function setTableSum(response, disabilites) {
        // Extract the summed data from the response
        const summedData = response.dataKeseluruhan;

        // Clear the table body before populating
        $('#tableSum tbody').empty();

        // Iterate over the disabilites array to dynamically generate rows
        disabilites.forEach(disabilitesKey => {
            // Extract the disabilites name from the key (e.g., "islam_lk" -> "Islam")
            const disabilitesName = disabilitesKey.replace(/(_lk|_pr|_jml)$/, '').toUpperCase();
            // Check if the disabilites name already exists in the table
            const existingRow = $(`#tableSum tbody tr:contains("${disabilitesName}")`);
            if (existingRow.length > 0) {
                // If the row already exists, update the values
                const row = existingRow[0];
                const cellType = disabilitesKey.split('_')[1]; // e.g., "lk", "pr", "jml"
                if (cellType === 'lk') {
                    $(row).find('td:eq(1)').text(summedData[disabilitesKey]); // Update Laki-Laki
                } else if (cellType === 'pr') {
                    $(row).find('td:eq(2)').text(summedData[disabilitesKey]); // Update Perempuan
                }else if (cellType === 'jml') {
                    $(row).find('td:eq(3)').text(summedData[disabilitesKey]); // Update jumlah
                }
            } else {
                // If the row does not exist, create a new row
                const row = `
                    <tr>
                        <td>${disabilitesName}</td>
                        <td>${summedData[`${disabilitesName.toLowerCase()}_lk`] || 0}</td>
                        <td>${summedData[`${disabilitesName.toLowerCase()}_pr`] || 0}</td>
                        <td>${summedData[`${disabilitesName.toLowerCase()}_jml`] || 0}</td>
                    </tr>
                `;
                $('#tableSum tbody').append(row);
            }
        });
    }
})(jQuery);