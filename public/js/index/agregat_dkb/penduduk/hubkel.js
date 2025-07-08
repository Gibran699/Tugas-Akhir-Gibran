(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formPendudukHubunganKeluarga'));
        const relationshipFamily = [
            "kepala_keluarga_l",
            "kepala_keluarga_p",
            "kepala_keluarga_jml",
            "suami_l",
            "suami_p",
            "suami_jml",
            "isteri_l",
            "isteri_p",
            "isteri_jml",
            "anak_l",
            "anak_p",
            "anak_jml",
            "menantu_l",
            "menantu_p",
            "menantu_jml",
            "cucu_l",
            "cucu_p",
            "cucu_jml",
            "orang_tua_l",
            "orang_tua_p",
            "orang_tua_jml",
            "mertua_l",
            "mertua_p",
            "mertua_jml",
            "famili_lain_l",
            "famili_lain_p",
            "famili_lain_jml",
            "pembantu_l",
            "pembantu_p",
            "pembantu_jml",
            "lainnya_l",
            "lainnya_p",
            "lainnya_jml",
        ];
        const headerTable = [
            'Kepala Keluarga', 'suami', 'istri','anak','menantu', 'cucu','orang tua' , 'mertua',
            'famili_lain','pembantu','lainya'
        ];
        $.ajax({
            url: $('#formPendudukHubunganKeluarga').attr('action'),
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
                setTableKelurahan(response, relationshipFamily);
                setTableKecamatan(response, relationshipFamily);
                setTableSum(response, relationshipFamily, headerTable);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Penduduk Hubungan Keluarga Tahun ${tahun} - Semester ${semester}`);
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

    function setTableKelurahan(response, relationshipFamily) {
        // Map the response to the dataSet format dynamically using the relationshipFamily array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama];

            // Dynamically add the relationshipFamily data based on the relationshipFamily array
            relationshipFamily.forEach(relationshipFamilyKey => {
                row.push(item[relationshipFamilyKey]); // Add the value from the item object
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

        // Add columns for each relationshipFamily key
        relationshipFamily.forEach(relationshipFamilyKey => {
            columns.push({ title: relationshipFamilyKey.toUpperCase() }); // Add the relationshipFamily key as the column title
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

    function setTableKecamatan(response, relationshipFamily) {
        // Map the response to the dataSet format dynamically using the relationshipFamily array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama];

            // Dynamically add the relationshipFamily data based on the relationshipFamily array
            relationshipFamily.forEach(relationshipFamilyKey => {
                row.push(item[relationshipFamilyKey]); // Add the value from the item object
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

        // Add columns for each relationshipFamily key
        relationshipFamily.forEach(relationshipFamilyKey => {
            columns.push({ title: relationshipFamilyKey.toUpperCase() }); // Add the relationshipFamily key as the column title
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
    function setTableSum(response, relationshipFamily, headerTable) {
        const summedData = response.dataKeseluruhan || {};
        const $tbody = $('#tableSum tbody');
        
        // Clear the table body more efficiently
        $tbody.empty();
    
        // Ensure we don't exceed either array's length
        const loopLength = Math.min(headerTable.length, relationshipFamily.length / 3);
        
        for (let i = 0; i < loopLength; i++) {
            const relationshipFamilyName = headerTable[i];
            const baseKey = relationshipFamily[i * 3].split('_').slice(0, -1).join('_'); // Get base key without suffix
            
            const row = `
                <tr>
                    <td>${relationshipFamilyName.toUpperCase()}</td>
                    <td>${summedData[`${baseKey}_l`] || 0}</td>
                    <td>${summedData[`${baseKey}_p`] || 0}</td>
                    <td>${summedData[`${baseKey}_jml`] || 0}</td>
                </tr>
            `;
            $tbody.append(row);
        }
    }
})(jQuery);