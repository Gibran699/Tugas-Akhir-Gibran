(function($) {
    $(document).ready(function() {
        $('#submitSearch').click(function() {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchPendudukJenisKelamin'));
        $.ajax({
            url: $('#formSearchPendudukJenisKelamin').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Harap Tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    type: 'success', // Updated to 'type' for newer SweetAlert versions
                    title: 'Berhasil',
                    text: response.message || 'Pencarian Berhasil!',
                });
                setTableKelurahan(response);
                setTableKecamatan(response);
                console.log(response);
                pieChart(response);
                $('#totalCard').text(response.dataKeseluruhan.total_jumlah);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Penduduk Jenis Kelamin Tahun ${tahun} - Semester ${semester}`);
            },
            error: function(xhr) {
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

    function setTableKelurahan(response) {
        // Map the response to the dataSet format
        let dataSet = response.dataPerkelurahan.map(item => [
            item.kecamatan_nama,
            item.kelurahan_nama,
            item.lk,
            item.pr,
            item.jumlah
        ]);

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#tableKelurahan')) {
            // If it is, destroy the existing DataTable instance
            $('#tableKelurahan').DataTable().clear().destroy();
        }

        // Initialize DataTable
        let table = $('#tableKelurahan').DataTable({
            data: dataSet,
            columns: [{
                    title: "KECAMATAN"
                },
                {
                    title: "KELURAHAN"
                },
                {
                    title: "LAKI-LAKI"
                },
                {
                    title: "PEREMPUAN"
                },
                {
                    title: "JUMLAH"
                },
            ],
            createdRow: function(row, data, index) {
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
        table.on('click', 'tbody tr', function() {
            var $row = table.row(this).nodes().to$();
            $row.toggleClass('selected');
        });

        // Remove 'selected' class from all rows initially
        table.rows().every(function() {
            this.nodes().to$().removeClass('selected');
        });
    }

    function setTableKecamatan(response) {
        // Map the response to the dataSet format
        let dataSet = response.dataPerkecamatan.map(item => [
            item.kecamatan_nama,
            item.total_lk,
            item.total_pr,
            item.total_jumlah
        ]);

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#tableKecamatan')) {
            // If it is, destroy the existing DataTable instance
            $('#tableKecamatan').DataTable().clear().destroy();
        }

        // Initialize DataTable
        let table = $('#tableKecamatan').DataTable({
            data: dataSet,
            columns: [{
                    title: "KECAMATAN"
                },
                {
                    title: "LAKI-LAKI"
                },
                {
                    title: "PEREMPUAN"
                },
                {
                    title: "JUMLAH"
                },
            ],
            createdRow: function(row, data, index) {
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
        table.on('click', 'tbody tr', function() {
            var $row = table.row(this).nodes().to$();
            $row.toggleClass('selected');
        });

        // Remove 'selected' class from all rows initially
        table.rows().every(function() {
            this.nodes().to$().removeClass('selected');
        });
    }
    var pieChart = function(response) {
        if (jQuery('#chartPendudukJenisKelamin').length > 0) {
            const dataKeseluruhan = response.dataKeseluruhan;
            if (dataKeseluruhan) {
                const pie_chart = document.getElementById("chartPendudukJenisKelamin").getContext('2d');
                new Chart(pie_chart, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [dataKeseluruhan.total_lk, dataKeseluruhan.total_pr],
                            borderWidth: 0,
                            backgroundColor: [
                                "rgba(235, 129, 83, .9)",
                                "rgba(235, 129, 83, .7)",
                            ],
                            hoverBackgroundColor: [
                                "rgba(235, 129, 83, .9)",
                                "rgba(235, 129, 83, .7)",
                            ]
                        }],
                        labels: [
                            "Laki-laki",
                            "Perempuan"
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: false,
                        maintainAspectRatio: false
                    }
                });
            } else {
                console.error('dataKeseluruhan is undefined');
            }
        }
    }
})(jQuery);