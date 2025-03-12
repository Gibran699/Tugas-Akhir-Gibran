(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchKepalaKeluargaStatusKawin'));
        const mariageStat = [
            'kawin_lk',
            'kawin_pr',
            'belum_kawin_lk',
            'belum_kawin_pr',
            'cerai_hidup_lk',
            'cerai_hidup_pr',
            'cerai_mati_lk',
            'cerai_mati_pr',
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
                setTableKelurahan(response, mariageStat);
                setTableKecamatan(response, mariageStat);
                setTableSum(response, mariageStat);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Kepala Keluarga Status Kawin Tahun ${tahun} - Semester ${semester}`);
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

    function setTableKelurahan(response, mariageStat) {
        // Map the response to the dataSet format dynamically using the mariageStat array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama];

            // Dynamically add the mariageStat data based on the mariageStat array
            mariageStat.forEach(mariageStatKey => {
                row.push(item[mariageStatKey]); // Add the value from the item object
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

        // Add columns for each mariageStat key
        mariageStat.forEach(mariageStatKey => {
            columns.push({ title: mariageStatKey.toUpperCase() }); // Add the mariageStat key as the column title
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

    function setTableKecamatan(response, mariageStat) {
        // Map the response to the dataSet format dynamically using the mariageStat array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the mariageStat data based on the mariageStat array
            mariageStat.forEach(mariageStatKey => {
                row.push(item[mariageStatKey]); // Add the value from the item object
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

        // Add columns for each mariageStat key
        mariageStat.forEach(mariageStatKey => {
            columns.push({ title: mariageStatKey.toUpperCase() }); // Add the mariageStat key as the column title
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
    function setTableSum(response, mariageStat) {
        // Extract the summed data from the response
        const summedData = response.dataKeseluruhan;

        // Clear the table body before populating
        $('#tableSum tbody').empty();

        // Iterate over the mariageStat array to dynamically generate rows
        mariageStat.forEach(mariageStatKey => {
            // Extract the mariageStat name from the key (e.g., "islam_lk" -> "Islam")
            const mariageStatName = mariageStatKey.replace(/(_lk|_pr)$/, '').toUpperCase();
            // Check if the mariageStat name already exists in the table
            const existingRow = $(`#tableSum tbody tr:contains("${mariageStatName}")`);
            if (existingRow.length > 0) {
                // If the row already exists, update the values
                const row = existingRow[0];
                const cellType = mariageStatKey.split('_')[1]; // e.g., "lk", "pr", "jml"
                if (cellType === 'lk') {
                    $(row).find('td:eq(1)').text(summedData[mariageStatKey]); // Update Laki-Laki
                } else if (cellType === 'pr') {
                    $(row).find('td:eq(2)').text(summedData[mariageStatKey]); // Update Perempuan
                }
            } else {
                // If the row does not exist, create a new row
                const row = `
                    <tr>
                        <td>${mariageStatName}</td>
                        <td>${summedData[`${mariageStatName.toLowerCase()}_lk`] || 0}</td>
                        <td>${summedData[`${mariageStatName.toLowerCase()}_pr`] || 0}</td>
                    </tr>
                `;
                $('#tableSum tbody').append(row);
            }
        });
    }
})(jQuery);