(function ($) {
    $(document).ready(function () {
        $('#submitSearch').click(function () {
            fetchData();
        });
    });

    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchDisabilitasPekerjaan'));
        const job = [
            'belum_tidak_bekerja_l',
            'belum_tidak_bekerja_p',
            'mengurus_rumah_tangga_l',
            'mengurus_rumah_tangga_p',
            'pelajar_mahasiswa_l',
            'pelajar_mahasiswa_p',
            'pensiunan_l',
            'pensiunan_p',
            'pegawai_negeri_sipil_pns_l',
            'pegawai_negeri_sipil_pns_p',
            'tentara_nasional_indonesia_tni_l',
            'tentara_nasional_indonesia_tni_p',
            'kepolisian_ri_polri_l',
            'kepolisian_ri_polri_p',
            'perdagangan_l',
            'perdagangan_p',
            'petani_pekebun_l',
            'petani_pekebun_p',
            'peternak_l',
            'peternak_p',
            'nelayan_perikanan_l',
            'nelayan_perikanan_p',
            'industri_l',
            'industri_p',
            'konstruksi_l',
            'konstruksi_p',
            'transportasi_l',
            'transportasi_p',
            'karyawan_swasta_l',
            'karyawan_swasta_p',
            'karyawan_bumn_l',
            'karyawan_bumn_p',
            'karyawan_bumd_l',
            'karyawan_bumd_p',
            'karyawan_honorer_l',
            'karyawan_honorer_p',
            'buruh_harian_lepas_l',
            'buruh_harian_lepas_p',
            'buruh_tani_perkebunan_l',
            'buruh_tani_perkebunan_p',
            'buruh_nelayan_perikanan_l',
            'buruh_nelayan_perikanan_p',
            'buruh_peternakan_l',
            'buruh_peternakan_p',
            'pembantu_rumah_tangga_l',
            'pembantu_rumah_tangga_p',
            'tukang_cukur_l',
            'tukang_cukur_p',
            'tukang_listrik_l',
            'tukang_listrik_p',
            'tukang_batu_l',
            'tukang_batu_p',
            'tukang_kayu_l',
            'tukang_kayu_p',
            'tukang_sol_sepatu_l',
            'tukang_sol_sepatu_p',
            'tukang_las_pandai_besi_l',
            'tukang_las_pandai_besi_p',
            'tukang_jahit_l',
            'tukang_jahit_p',
            'tukang_gigi_l',
            'tukang_gigi_p',
            'penata_rias_l',
            'penata_rias_p',
            'penata_busana_l',
            'penata_busana_p',
            'penata_rambut_l',
            'penata_rambut_p',
            'mekanik_l',
            'mekanik_p',
            'seniman_l',
            'seniman_p',
            'tabib_l',
            'tabib_p',
            'paraji_l',
            'paraji_p',
            'perancang_busana_l',
            'perancang_busana_p',
            'penterjemah_l',
            'penterjemah_p',
            'imam_masjid_l',
            'imam_masjid_p',
            'pendeta_l',
            'pendeta_p',
            'pastor_l',
            'pastor_p',
            'wartawan_l',
            'wartawan_p',
            'ustadz_mubaligh_l',
            'ustadz_mubaligh_p',
            'juru_masak_l',
            'juru_masak_p',
            'promotor_acara_l',
            'promotor_acara_p',
            'anggota_dpr_ri_l',
            'anggota_dpr_ri_p',
            'anggota_dpd_ri_l',
            'anggota_dpd_ri_p',
            'anggota_bpk_l',
            'anggota_bpk_p',
            'presiden_l',
            'presiden_p',
            'wakil_presiden_l',
            'wakil_presiden_p',
            'anggota_mahkamah_konstitusi_l',
            'anggota_mahkamah_konstitusi_p',
            'anggota_kabinet_kementerian_l',
            'anggota_kabinet_kementerian_p',
            'duta_besar_l',
            'duta_besar_p',
            'gubernur_l',
            'gubernur_p',
            'wakil_gubernur_l',
            'wakil_gubernur_p',
            'bupati_l',
            'bupati_p',
            'wakil_bupati_l',
            'wakil_bupati_p',
            'walikota_l',
            'walikota_p',
            'wakil_walikota_l',
            'wakil_walikota_p',
            'anggota_dprd_prop_l',
            'anggota_dprd_prop_p',
            'anggota_dprd_kab_kota_l',
            'anggota_dprd_kab_kota_p',
            'dosen_l',
            'dosen_p',
            'guru_l',
            'guru_p',
            'pilot_l',
            'pilot_p',
            'pengacara_l',
            'pengacara_p',
            'notaris_l',
            'notaris_p',
            'arsitek_l',
            'arsitek_p',
            'akuntan_l',
            'akuntan_p',
            'konsultan_l',
            'konsultan_p',
            'dokter_l',
            'dokter_p',
            'bidan_l',
            'bidan_p',
            'perawat_l',
            'perawat_p',
            'apoteker_l',
            'apoteker_p',
            'psikiater_psikolog_l',
            'psikiater_psikolog_p',
            'penyiar_televisi_l',
            'penyiar_televisi_p',
            'penyiar_radio_l',
            'penyiar_radio_p',
            'pelaut_l',
            'pelaut_p',
            'peneliti_l',
            'peneliti_p',
            'sopir_l',
            'sopir_p',
            'pialang_l',
            'pialang_p',
            'paranormal_l',
            'paranormal_p',
            'pedagang_l',
            'pedagang_p',
            'perangkat_desa_l',
            'perangkat_desa_p',
            'kepala_desa_l',
            'kepala_desa_p',
            'biarawan_biarawati_l',
            'biarawan_biarawati_p',
            'wiraswasta_l',
            'wiraswasta_p',
            'anggota_lembaga_tinggi_lainnya_l',
            'anggota_lembaga_tinggi_lainnya_p',
            'artis_l',
            'artis_p',
            'atlit_l',
            'atlit_p',
            'chef_l',
            'chef_p',
            'manajer_l',
            'manajer_p',
            'tenaga_tata_usaha_l',
            'tenaga_tata_usaha_p',
            'operator_l',
            'operator_p',
            'pekerja_pengolahan_kerajinan_l',
            'pekerja_pengolahan_kerajinan_p',
            'teknisi_l',
            'teknisi_p',
            'asisten_ahli_l',
            'asisten_ahli_p',
            'pekerjaan_lainnya_l',
            'pekerjaan_lainnya_p',
        ];
        $.ajax({
            url: $('#formSearchDisabilitasPekerjaan').attr('action'),
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
                setTableKelurahan(response, job);
                setTableKecamatan(response, job);
                setTableSum(response, job);
                // Set the value of #tahunSemester dynamically
                const semester = response.dataTitle.semester || "N/A";
                const tahun = response.dataTitle.tahun || "N/A";
                $("#tahunSemester").text(`Disabilitas Pekerjaan Tahun ${tahun} - Semester ${semester}`);
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

    function setTableKelurahan(response, job) {
        // Map the response to the dataSet format dynamically using the job array
        let dataSet = response.dataPerkelurahan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.kelurahan_nama, item.keterangan];

            // Dynamically add the job data based on the job array
            job.forEach(jobKey => {
                row.push(item[jobKey]); // Add the value from the item object
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

        // Add columns for each job key
        job.forEach(jobKey => {
            columns.push({ title: jobKey.toUpperCase() }); // Add the job key as the column title
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

    function setTableKecamatan(response, job) {
        // Map the response to the dataSet format dynamically using the job array
        let dataSet = response.dataPerkecamatan.map(item => {
            // Start with the fixed columns (kecamatan_nama and kelurahan_nama)
            let row = [item.kecamatan_nama, item.keterangan];

            // Dynamically add the job data based on the job array
            job.forEach(jobKey => {
                row.push(item[jobKey]); // Add the value from the item object
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

        // Add columns for each job key
        job.forEach(jobKey => {
            columns.push({ title: jobKey.toUpperCase() }); // Add the job key as the column title
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
    function setTableSum(response, job) {
        const summedData = response.dataKeseluruhan;

        if ($.fn.DataTable.isDataTable('#tableSum')) {
            $('#tableSum').DataTable().clear().destroy();
        }

        const tableData = [];

        summedData.forEach(data => {
            job.forEach(jobKey => {
                // const jobName = jobKey.split('_')[0].charAt(0).toUpperCase() + jobKey.split('_')[0].slice(1);
                const jobName = jobKey.toUpperCase();

                const row = [
                    jobName, // Agama
                    data.keterangan, // Keterangan
                    data[`${jobKey}`] || 0 // Jumlah
                ];
                tableData.push(row);
            });
        });

        $('#tableSum').DataTable({
            data: tableData,
            columns: [
                { title: "Pekerjaan" },
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
