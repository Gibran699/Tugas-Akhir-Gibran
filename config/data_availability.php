<?php

/*
|--------------------------------------------------------------------------
| Data Availability Registry
|--------------------------------------------------------------------------
| Daftar semua fitur, entitas, dan dimensi beserta nama tabel database-nya.
| Digunakan oleh DataAvailabilityService untuk mengecek ketersediaan data.
|
| Struktur: features[feature_key][entities][entity_key][dimensions][dim_key]
|
| Setiap dimensi WAJIB memiliki:
|   - label : nama tampilan yang ramah pengguna
|   - table : nama tabel database aktual (sesuai $table di model)
|
| Kolom yang wajib ada di setiap tabel data:
|   kode_wilayah, tahun, semester
|   (deleted_at opsional — dicek otomatis oleh service)
*/

return [

    // =========================================================
    // A. FITUR DATA DKB
    // =========================================================
    'data_dkb' => [
        'label' => 'Data DKB',
        'entities' => [

            // ── Penduduk ──────────────────────────────────────
            'penduduk' => [
                'label' => 'Penduduk',
                'dimensions' => [
                    'agama' => [
                        'label' => 'Agama',
                        'table' => 'agama_penduduk',                    // AgregatDKB\Penduduk\Agama
                    ],
                    'golongan_darah' => [
                        'label' => 'Golongan Darah',
                        'table' => 'golongan_darah_penduduk',           // AgregatDKB\Penduduk\GolonganDarah
                    ],
                    'jenis_kelamin' => [
                        'label' => 'Jenis Kelamin',
                        'table' => 'jenis_kelamin_penduduk',            // AgregatDKB\Penduduk\JenisKelamin
                    ],
                    'pekerjaan' => [
                        'label' => 'Pekerjaan',
                        'table' => 'pekerjaan_penduduk',                // AgregatDKB\Penduduk\Pekerjaan
                    ],
                    'hubungan_keluarga' => [
                        'label' => 'Hubungan Keluarga',
                        'table' => 'hubungan_keluarga_penduduk',        // AgregatDKB\Penduduk\HubunganKeluarga
                    ],
                ],
            ],

            // ── Kepala Keluarga ───────────────────────────────
            'kepala_keluarga' => [
                'label' => 'Kepala Keluarga',
                'dimensions' => [
                    'agama' => [
                        'label' => 'Agama',
                        'table' => 'agama_kepala_keluarga',             // AgregatDKB\KepalaKeluarga\Agama
                    ],
                    'jenis_kelamin' => [
                        'label' => 'Jenis Kelamin',
                        'table' => 'jenis_kelamin_kepala_keluarga',     // AgregatDKB\KepalaKeluarga\JenisKelamin
                    ],
                    'pendidikan' => [
                        'label' => 'Pendidikan',
                        'table' => 'pendidikan_kepala_keluarga',        // AgregatDKB\KepalaKeluarga\Pendidikan
                    ],
                    'pekerjaan' => [
                        'label' => 'Pekerjaan',
                        'table' => 'pekerjaan_kepala_keluarga',         // AgregatDKB\KepalaKeluarga\Pekerjaan
                    ],
                    'status_kawin' => [
                        'label' => 'Status Kawin',
                        'table' => 'status_kawin_kepala_keluarga',      // AgregatDKB\KepalaKeluarga\StatusKawin
                    ],
                ],
            ],

            // ── Status Kawin ──────────────────────────────────
            'status_kawin' => [
                'label' => 'Status Kawin',
                'dimensions' => [
                    'agama' => [
                        'label' => 'Agama',
                        'table' => 'status_kawin_penduduk_agama',           // AgregatDKB\StatusKawin\Agama
                    ],
                    'jenis_kelamin' => [
                        'label' => 'Jenis Kelamin',
                        'table' => 'status_kawin_penduduk_jenis_kelamin',   // AgregatDKB\StatusKawin\JenisKelamin
                    ],
                    'pekerjaan' => [
                        'label' => 'Pekerjaan',
                        'table' => 'status_kawin_penduduk_pekerjaan',       // AgregatDKB\StatusKawin\Pekerjaan
                    ],
                ],
            ],

            // ── Pendidikan ────────────────────────────────────
            'pendidikan' => [
                'label' => 'Pendidikan',
                'dimensions' => [
                    'jenis_kelamin' => [
                        'label' => 'Jenis Kelamin',
                        'table' => 'jenis_kelamin_pendidikan',          // AgregatDKB\Pendidikan\JenisKelamin
                    ],
                    'pekerjaan' => [
                        'label' => 'Pekerjaan',
                        'table' => 'pendidikan_penduduk_pekerjaan',     // AgregatDKB\Pendidikan\Pekerjaan
                    ],
                    'golongan_darah' => [
                        'label' => 'Golongan Darah',
                        'table' => 'golongan_darah_pendidikan',         // AgregatDKB\Pendidikan\GolonganDarah
                    ],
                ],
            ],

            // ── Disabilitas ───────────────────────────────────
            'disabilitas' => [
                'label' => 'Disabilitas',
                'dimensions' => [
                    'jenis_kelamin' => [
                        'label' => 'Jenis Kelamin',
                        'table' => 'jenis_kelamin_disabilitas',         // AgregatDKB\Disabilitas\JenisKelamin
                    ],
                    'pekerjaan' => [
                        'label' => 'Pekerjaan',
                        'table' => 'pekerjaan_disabilitas',             // AgregatDKB\Disabilitas\Pekerjaan
                    ],
                    'pendidikan' => [
                        'label' => 'Pendidikan',
                        'table' => 'pendidikan_disabilitas',            // AgregatDKB\Disabilitas\Pendidikan
                    ],
                ],
            ],

        ],
    ],

    // =========================================================
    // B. FITUR KEPEMILIKAN DOKUMEN
    // =========================================================
    'kepemilikan' => [
        'label' => 'Kepemilikan Dokumen',
        'entities' => [

            'akta_kelahiran' => [
                'label' => 'Akta Kelahiran',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Akta Kelahiran',
                        'table' => 'akta_kelahiran',                    // Kepemilikan\AktaKelahiran
                    ],
                ],
            ],

            'akta_kawin' => [
                'label' => 'Akta Perkawinan',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Akta Perkawinan',
                        'table' => 'akta_kawin',                        // Kepemilikan\AktaKawin
                    ],
                ],
            ],

            'akta_kawin_agama' => [
                'label' => 'Akta Perkawinan – Agama',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Akta Perkawinan Agama',
                        'table' => 'akta_kawin_agama',                  // Kepemilikan\AktaKawinAgama
                    ],
                ],
            ],

            'akta_cerai' => [
                'label' => 'Akta Perceraian',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Akta Perceraian',
                        'table' => 'akta_cerai',                        // Kepemilikan\AktaCerai
                    ],
                ],
            ],

            'akta_cerai_agama' => [
                'label' => 'Akta Perceraian – Agama',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Akta Perceraian Agama',
                        'table' => 'akta_cerai_agama',                  // Kepemilikan\AktaCeraiAgama
                    ],
                ],
            ],

            'kia' => [
                'label' => 'KIA (Kartu Identitas Anak)',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data KIA',
                        'table' => 'kia',                               // Kepemilikan\KIA
                    ],
                ],
            ],

            'kartu_keluarga' => [
                'label' => 'Kartu Keluarga',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Kartu Keluarga',
                        'table' => 'kartu_keluarga',                    // Kepemilikan\KartuKeluarga
                    ],
                ],
            ],

            'ktp' => [
                'label' => 'KTP',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data KTP',
                        'table' => 'ktp',                               // Kepemilikan\Ktp
                    ],
                ],
            ],

        ],
    ],

    // =========================================================
    // C. FITUR STRUKTUR UMUR
    // =========================================================
    'struktur_umur' => [
        'label' => 'Struktur Umur',
        'entities' => [

            // ── Agama ─────────────────────────────────────────
            'agama' => [
                'label' => 'Agama',
                'dimensions' => [
                    'kelompok_umur' => [
                        'label' => 'Kelompok Umur',
                        'table' => 'kelompok_umur_agama',               // StrukturUmur\Agama\KelompokUmur
                    ],
                ],
            ],

            // ── Disabilitas ───────────────────────────────────
            'disabilitas' => [
                'label' => 'Disabilitas',
                'dimensions' => [
                    'kelompok_umur' => [
                        'label' => 'Kelompok Umur',
                        'table' => 'kelompok_umur_disabilitas',         // StrukturUmur\Disabilitas\KelompokUmur
                    ],
                    'pendidikan' => [
                        'label' => 'Pendidikan (Umur Tunggal)',
                        'table' => 'pendidikan_umur_tunggal_disabilitas', // StrukturUmur\Disabilitas\PendidikanUmurTunggal
                    ],
                    'umur_tunggal' => [
                        'label' => 'Umur Tunggal',
                        'table' => 'umur_tunggal_disabilitas',          // StrukturUmur\Disabilitas\UmurTunggal
                    ],
                    'usia_sekolah' => [
                        'label' => 'Usia Sekolah',
                        'table' => 'usia_sekolah_kelompok_umur_disabilitas', // StrukturUmur\Disabilitas\UsiaSekolahKelompokUmur
                    ],
                ],
            ],

            // ── Golongan Darah ────────────────────────────────
            'golongan_darah' => [
                'label' => 'Golongan Darah',
                'dimensions' => [
                    'kelompok_umur' => [
                        'label' => 'Kelompok Umur',
                        'table' => 'kelompok_umur_golongan_darah',      // StrukturUmur\GolonganDarah\KelompokUmur
                    ],
                    'umur_tunggal' => [
                        'label' => 'Umur Tunggal',
                        'table' => 'umur_tunggal_golongan_darah',       // StrukturUmur\GolonganDarah\UmurTunggal
                    ],
                ],
            ],

            // ── Kepala Keluarga ───────────────────────────────
            'kepala_keluarga' => [
                'label' => 'Kepala Keluarga',
                'dimensions' => [
                    'kelompok_umur' => [
                        'label' => 'Kelompok Umur',
                        'table' => 'kelompok_umur_kepala_keluarga',     // StrukturUmur\KepalaKeluarga\KelompokUmur
                    ],
                    'umur_tunggal' => [
                        'label' => 'Umur Tunggal',
                        'table' => 'umur_tunggal_kepala_keluarga',      // StrukturUmur\KepalaKeluarga\UmurTunggal
                    ],
                    'status_kawin' => [
                        'label' => 'Status Kawin (Kelompok Umur)',
                        'table' => 'status_kawin_kelompok_umur_kepala_keluarga', // StrukturUmur\KepalaKeluarga\StatusKawinKelompokUmur
                    ],
                ],
            ],

            // ── Penduduk ──────────────────────────────────────
            'penduduk' => [
                'label' => 'Penduduk',
                'dimensions' => [
                    'umur_tunggal_jk' => [
                        'label' => 'Umur Tunggal – Jenis Kelamin',
                        'table' => 'umur_tunggal_penduduk',             // StrukturUmur\Penduduk\UmurTunggal
                    ],
                    'umur_tunggal_sk' => [
                        'label' => 'Umur Tunggal – Status Kawin',
                        'table' => 'status_kawin_umur_tunggal_penduduk', // StrukturUmur\Penduduk\StatusKawinUmurTunggal
                    ],
                    'kelompok_umur_jk' => [
                        'label' => 'Kelompok Umur – Jenis Kelamin',
                        'table' => 'kelompok_umur_penduduk',            // StrukturUmur\Penduduk\KelompokUmur
                    ],
                    'kelompok_umur_sk' => [
                        'label' => 'Kelompok Umur – Status Kawin',
                        'table' => 'status_kawin_kelompok_umur_penduduk', // StrukturUmur\Penduduk\StatusKawinKelompokUmur
                    ],
                    'usia_sekolah' => [
                        'label' => 'Usia Sekolah',
                        'table' => 'usia_sekolah_penduduk',             // StrukturUmur\Penduduk\UsiaSekolah
                    ],
                    'demografi_usia' => [
                        'label' => 'Demografi Usia (Muda/Produktif/Tua)',
                        'table' => 'usia_muda_produktif_tua_penduduk',  // StrukturUmur\Penduduk\UsiaMudaProduktifTua
                    ],
                ],
            ],

        ],
    ],

    // =========================================================
    // D. FITUR STATISTIK KELOMPOK UMUR
    // =========================================================
    'statistik_kelompok_umur' => [
        'label' => 'Statistik Kelompok Umur',
        'entities' => [

            'disabilitas' => [
                'label' => 'Disabilitas',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Disabilitas',
                        'table' => 'umur_tunggal_disabilitas',          // StrukturUmur\Disabilitas\UmurTunggal
                    ],
                ],
            ],

            'disabilitas_pendidikan' => [
                'label' => 'Disabilitas Pendidikan',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Disabilitas Pendidikan',
                        'table' => 'pendidikan_umur_tunggal_disabilitas', // StrukturUmur\Disabilitas\PendidikanUmurTunggal
                    ],
                ],
            ],

            'golongan_darah' => [
                'label' => 'Golongan Darah',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Golongan Darah',
                        'table' => 'umur_tunggal_golongan_darah',       // StrukturUmur\GolonganDarah\UmurTunggal
                    ],
                ],
            ],

            'kepala_keluarga' => [
                'label' => 'Kepala Keluarga',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Kepala Keluarga',
                        'table' => 'umur_tunggal_kepala_keluarga',      // StrukturUmur\KepalaKeluarga\UmurTunggal
                    ],
                ],
            ],

            'penduduk' => [
                'label' => 'Penduduk',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Penduduk',
                        'table' => 'umur_tunggal_penduduk',             // StrukturUmur\Penduduk\UmurTunggal
                    ],
                ],
            ],

            'penduduk_status_kawin' => [
                'label' => 'Penduduk Stat. Kawin',
                'dimensions' => [
                    'default' => [
                        'label' => 'Data Status Kawin Umur Tunggal',
                        'table' => 'status_kawin_umur_tunggal_penduduk', // StrukturUmur\Penduduk\StatusKawinUmurTunggal
                    ],
                ],
            ],

        ],
    ],

];
