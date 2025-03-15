(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchKepemilikanAktaKawinAgama'));
        const religious = [
            'islam_memiliki_lk',
            'islam_memiliki_pr',
            'islam_memiliki_jml',
            'islam_blm_memiliki_jml',
            'kristen_memiliki_lk',
            'kristen_memiliki_pr',
            'kristen_memiliki_jml',
            'kristen_blm_memiliki_jml',
            'katholik_memiliki_lk',
            'katholik_memiliki_pr',
            'katholik_memiliki_jml',
            'katholik_blm_memiliki_jml',
            'hindu_memiliki_lk',
            'hindu_memiliki_pr',
            'hindu_memiliki_jml',
            'hindu_blm_memiliki_jml',
            'budha_memiliki_lk',
            'budha_memiliki_pr',
            'budha_memiliki_jml',
            'budha_blm_memiliki_jml',
            'khonghucu_memiliki_lk',
            'khonghucu_memiliki_pr',
            'khonghucu_memiliki_jml',
            'khonghucu_blm_memiliki_jml',
            'kepercayaan_memiliki_lk',
            'kepercayaan_memiliki_pr',
            'kepercayaan_memiliki_jml',
            'kepercayaan_blm_memiliki_jml',
        ];
        $.ajax({
            url: $('#formSearchKepemilikanAktaKawinAgama').attr('action'),
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
                $("#tahunSemester").text(`Kepemilikan Akta Kawin Agama Tahun ${tahun} - Semester ${semester}`);
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
        const summedData = response.dataKeseluruhan;
        const tableBody = $('#tableSum tbody');

        // Clear the table body before populating
        tableBody.empty();

        // Create a map to group data by religion
        const religionMap = {};

        // Process each religious key and group data by religion
        religious.forEach(religionKey => {
            const [religion, type, gender] = religionKey.split('_');
            const religionName = religion.toUpperCase();

            // Initialize the religion entry if it doesn't exist
            if (!religionMap[religionName]) {
                religionMap[religionName] = {
                    memiliki_lk: 0,
                    memiliki_pr: 0,
                    memiliki_jml: 0,
                    blm_memiliki_jml: 0,
                };
            }

            // Update the corresponding field in the map
            if (type === 'memiliki') {
                religionMap[religionName][`${type}_${gender}`] = summedData[religionKey] || 0;
            } else if (type === 'blm' && gender === 'memiliki') {
                // Handle the "blm_memiliki_jml" case
                religionMap[religionName].blm_memiliki_jml = summedData[religionKey] || 0;
            }
        });

        // Generate rows from the grouped data
        Object.entries(religionMap).forEach(([religionName, data]) => {
            const row = `
                <tr>
                    <td>${religionName}</td>
                    <td>${data.memiliki_lk}</td>
                    <td>${data.memiliki_pr}</td>
                    <td>${data.memiliki_jml}</td>
                    <td>${data.blm_memiliki_jml}</td>
                </tr>
            `;
            tableBody.append(row);
        });
    }
})(jQuery);