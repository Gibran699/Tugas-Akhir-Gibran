(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchKepalaKeluargaAgama'));
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
            url: $('#formSearchKepalaKeluargaAgama').attr('action'),
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
            let row = [item.kecamatan_nama, item.kelurahan_nama];

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
            { title: "KELURAHAN" }
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
            let row = [item.kecamatan_nama];

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
            { title: "KECAMATAN" }
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
    function setTableSum(response, religious) {
        // Extract the summed data from the response
        const summedData = response.dataKeseluruhan;

        // Clear the table body before populating
        $('#tableSum tbody').empty();

        // Iterate over the religious array to dynamically generate rows
        religious.forEach(religionKey => {
            // Extract the religion name from the key (e.g., "islam_lk" -> "Islam")
            const religionName = religionKey.split('_')[0].toUpperCase();

            // Check if the religion name already exists in the table
            const existingRow = $(`#tableSum tbody tr:contains("${religionName}")`);
            if (existingRow.length > 0) {
                // If the row already exists, update the values
                const row = existingRow[0];
                const cellType = religionKey.split('_')[1]; // e.g., "lk", "pr", "jml"
                if (cellType === 'lk') {
                    $(row).find('td:eq(1)').text(summedData[religionKey]); // Update Laki-Laki
                } else if (cellType === 'pr') {
                    $(row).find('td:eq(2)').text(summedData[religionKey]); // Update Perempuan
                } else if (cellType === 'jml') {
                    $(row).find('td:eq(3)').text(summedData[religionKey]); // Update Jumlah
                }
            } else {
                // If the row does not exist, create a new row
                const row = `
                    <tr>
                        <td>${religionName}</td>
                        <td>${summedData[`${religionName.toLowerCase()}_lk`] || 0}</td>
                        <td>${summedData[`${religionName.toLowerCase()}_pr`] || 0}</td>
                        <td>${summedData[`${religionName.toLowerCase()}_jml`] || 0}</td>
                    </tr>
                `;
                $('#tableSum tbody').append(row);
            }
        });
    }
})(jQuery);