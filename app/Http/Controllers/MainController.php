<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MainController extends Controller
{
    function index($codeView)
    {
        $redirectView = [
            "MupFCfSa6a" => "agregat_dkb.penduduk.agama_index",
            "aPH7zF09S1" => "agregat_dkb.penduduk.golongan_darah_index",
            "CV8V59hUCF" => "agregat_dkb.penduduk.jenis_kelamin_index",
            "fFKZKP7AnA" => "agregat_dkb.penduduk.pekerjaan_index",
            "bfl4aaeCTi" => "agregat_dkb.penduduk.hubungan_keluarga_index",
            "nYtZCUxdr6" => "agregat_dkb.kepala_keluarga.agama_index",
            "MNJiVyMrxR" => "agregat_dkb.kepala_keluarga.jenis_kelamin_index",
            "gblPf8pfSp" => "agregat_dkb.kepala_keluarga.pendidikan_index",
            "aQIpF1uiEO" => "agregat_dkb.kepala_keluarga.pekerjaan_index",
            "ZvGL0vPJLC" => "agregat_dkb.kepala_keluarga.status_kawin_index",
            "2XSDKgCQJH" => "agregat_dkb.status_kawin.agama_index",
            "oqhOV9WfkB" => "agregat_dkb.status_kawin.jenis_kelamin_index",
            "AWn2KmOLao" => "agregat_dkb.status_kawin.pekerjaan_index",
            "XYPtrXHZkf" => "agregat_dkb.pendidikan.jenis_kelamin_index",
            "XYPt22HZkf" => "agregat_dkb.pendidikan.golongan_darah_index",
            "eRPt22HZkf" => "agregat_dkb.pendidikan.pekerjaan_index",
            "trg1Xxialt" => "agregat_dkb.disabilitas.jenis_kelamin_index",
            "iXnbXnoUnq" => "agregat_dkb.disabilitas.pekerjaan_index",
            "8sfHKi6GHS" => "agregat_dkb.disabilitas.pendidikan_index",
            "6D6A18O1Hm" => "kepemilikan.akta_kelahiran",
            "CJY6qXue82" => "kepemilikan.akta_kawin",
            "PKf3FqywDa" => "kepemilikan.akta_kawin_agama",
            "goKsHUTCOG" => "kepemilikan.akta_cerai",
            "eCnoaOxtiS" => "kepemilikan.akta_cerai_agama",
            "2ovlKZBzGU" => "kepemilikan.kia",
            "6DFxmctALZ" => "kepemilikan.kartu_keluarga",
            "hsdtkgPeS5" => "kepemilikan.ktp",
            "OqF8P0knI7" => "struktur_umur.agama.kelompok_umur_index",
            "VtDkcpu8FN" => "struktur_umur.disabilitas.kelompok_umur_index",
            "nx8eUW4TWq" => "struktur_umur.disabilitas.pendidikan_umur_tunggal_index",
            "3WjgN9m6aS" => "struktur_umur.disabilitas.umur_tunggal_index",
            "FIZKE9hOxo" => "struktur_umur.disabilitas.usia_sekolah_kelompok_umur_index",
            "dRgHdz0S5A" => "struktur_umur.golongan_darah.kelompok_umur_index",
            "eRkbPisQHv" => "struktur_umur.golongan_darah.umur_tunggal_index",
            "svFaBJRBLQ" => "struktur_umur.kepala_keluarga.kelompok_umur_index",
            "EJpy2qXC3z" => "struktur_umur.kepala_keluarga.status_kawin_kelompok_umur_index",
            "lo4z2cDrRC" => "struktur_umur.kepala_keluarga.umur_tunggal_index",
            "gWNOWEQuYC" => "struktur_umur.penduduk.kelompok_umur_index",
            "RIvQj7G1XZ" => "struktur_umur.penduduk.status_kawin_kelompok_umur_index",
            "4riLDLsE6q" => "struktur_umur.penduduk.status_kawin_umur_tunggal_index",
            "Byxp2PxZK2" => "struktur_umur.penduduk.umur_tunggal_index",
            "7fKa0gsKtH" => "struktur_umur.penduduk.usia_muda_produkif_tua_index",
            "ObqRhsP78G" => "struktur_umur.penduduk.usia_sekolah_index",
            "qhihTlpdZ1" => "pengaturan.user.create_index",
            "IxmdS85aaN" => "pengaturan.permission.create_index",
            "IoCU7M9OL8" => "pengaturan.role.create_index",
        ];
        // Check if the $codeView exists in the $redirectView array
        if (isset($redirectView[$codeView])) {
            // Return the corresponding view
            return view($redirectView[$codeView]);
        }

        // Fallback for invalid $codeView (e.g., show a 404 page or redirect)
        return abort(404, 'View not found');
    }
}
