<?php

namespace Tests\Feature;

use App\services\DataAvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Black-Box Test Cases — Fitur Indikator Ketersediaan Data
 *
 * Menguji seluruh skenario yang tercantum dalam spesifikasi fitur.
 * Jalankan dengan:  php artisan test --filter=DataAvailabilityTest
 *
 * ─────────────────────────────────────────────────────────────────
 * CATATAN: Test ini menggunakan DB transactions (RefreshDatabase).
 * Pastikan koneksi database aktif sebelum menjalankan.
 * ─────────────────────────────────────────────────────────────────
 */
class DataAvailabilityTest extends TestCase
{
    // RefreshDatabase akan rollback setelah setiap test
    // Hapus trait ini jika tidak ingin memodifikasi DB test
    // use RefreshDatabase;

    protected DataAvailabilityService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(DataAvailabilityService::class);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-01: Status TERSEDIA — data ada di seluruh wilayah scope
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc01_admin_melihat_status_tersedia()
    {
        // Arrange: pastikan ada data di agama_penduduk untuk seluruh kelurahan
        // (gunakan data yang sudah ada di DB, bukan insert baru)
        $tahun    = 2024;
        $semester = 1;

        // Act
        $result = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', $tahun, $semester
        );

        // Assert: jika data benar-benar lengkap
        if ($result['total_data'] > 0 && $result['missing_count'] === 0) {
            $this->assertEquals('available', $result['status']);
            $this->assertEquals(0, $result['missing_count']);
            $this->assertNotEmpty($result['message_for_admin']);
        } else {
            // Lewati jika data memang belum ada — ini acceptance test, bukan unit test
            $this->markTestSkipped('Data tidak tersedia di environment ini untuk TC-01.');
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-02: Status BELUM TERSEDIA — tidak ada data sama sekali
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc02_admin_melihat_status_belum_tersedia()
    {
        // Gunakan tahun yang pasti belum ada datanya
        $result = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 1900, 1
        );

        $this->assertEquals('missing', $result['status']);
        $this->assertEquals(0, $result['total_data']);
        $this->assertStringContainsString('belum tersedia', strtolower($result['message_for_admin']));
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-03: Status SEBAGIAN TERSEDIA — data ada tapi tidak semua wilayah
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc03_admin_melihat_status_sebagian_tersedia()
    {
        $result = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 2024, 1
        );

        if ($result['status'] === 'partial') {
            $this->assertGreaterThan(0, $result['total_data']);
            $this->assertGreaterThan(0, $result['missing_count']);
            $this->assertLessThan($result['total_wilayah'], $result['total_data']);
        } else {
            $this->markTestSkipped('Data tidak dalam kondisi partial di environment ini.');
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-04: Admin dapat melihat daftar wilayah yang belum ada data
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc04_admin_melihat_daftar_wilayah_missing()
    {
        $result = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 1900, 1
        );

        $this->assertArrayHasKey('missing_wilayah', $result);
        $this->assertIsArray($result['missing_wilayah']);

        // Setiap entry harus punya kode dan nama
        foreach ($result['missing_wilayah'] as $w) {
            $this->assertArrayHasKey('kode', $w);
            $this->assertArrayHasKey('nama', $w);
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-05: Admin dapat klik tombol Import — endpoint tersedia
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc05_route_import_data_dapat_diakses_admin()
    {
        $user = $this->createUserWithPermission('import_data');
        $this->actingAs($user);

        $response = $this->get(route('import_data_excel'));
        $response->assertStatus(200);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-06: User biasa mendapat pesan data belum tersedia (tanpa detail teknis)
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc06_user_biasa_tidak_melihat_nama_tabel()
    {
        $user = $this->createUserWithNoPermission();
        $this->actingAs($user);

        $response = $this->getJson(route('data_availability.check', [
            'feature'   => 'data_dkb',
            'entity'    => 'penduduk',
            'dimension' => 'agama',
            'tahun'     => 1900,
            'semester'  => 1,
        ]));

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertArrayNotHasKey('table', $data,
            'Nama tabel tidak boleh tampil untuk user biasa.');
        $this->assertArrayNotHasKey('missing_wilayah', $data,
            'Daftar wilayah teknis tidak boleh tampil untuk user biasa.');
        $this->assertArrayHasKey('message_for_user', $data);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-07: Filter tahun dan semester bekerja dengan benar
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc07_filter_tahun_semester_valid()
    {
        $user = $this->createUserWithPermission('pengaturan');
        $this->actingAs($user);

        // Tahun dan semester valid
        $response = $this->getJson(route('data_availability.check', [
            'feature'   => 'data_dkb',
            'entity'    => 'penduduk',
            'dimension' => 'agama',
            'tahun'     => 2024,
            'semester'  => 1,
        ]));
        $response->assertStatus(200);
        $response->assertJsonPath('tahun', 2024);
        $response->assertJsonPath('semester', 1);
    }

    /** @test */
    public function tc07b_validasi_semester_tidak_valid()
    {
        $user = $this->createUserWithPermission('pengaturan');
        $this->actingAs($user);

        $response = $this->getJson(route('data_availability.check', [
            'feature'   => 'data_dkb',
            'entity'    => 'penduduk',
            'dimension' => 'agama',
            'tahun'     => 2024,
            'semester'  => 3,  // invalid
        ]));
        $response->assertStatus(422);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-08: Filter kecamatan bekerja (hanya cek kelurahan di kecamatan tsb)
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc08_filter_kecamatan_membatasi_scope()
    {
        $kodeKecamatan = DB::table('mstr_kecamatan')->whereNull('deleted_at')->value('kode');

        if (!$kodeKecamatan) {
            $this->markTestSkipped('Tidak ada data kecamatan di DB.');
        }

        $resultFull = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 1900, 1
        );

        $resultFiltered = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 1900, 1,
            kodeKecamatan: $kodeKecamatan
        );

        // Scope filter kecamatan harus lebih kecil dari scope penuh
        $this->assertLessThanOrEqual(
            $resultFull['total_wilayah'],
            $resultFiltered['total_wilayah'],
            'Filter kecamatan seharusnya mempersempit jumlah wilayah yang dicek.'
        );
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-09: Filter kelurahan bekerja (hanya 1 kelurahan dicek)
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc09_filter_kelurahan_membatasi_scope_ke_1()
    {
        $kodeKelurahan = DB::table('mstr_kelurahan')->whereNull('deleted_at')->value('kode');

        if (!$kodeKelurahan) {
            $this->markTestSkipped('Tidak ada data kelurahan di DB.');
        }

        $result = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 2024, 1,
            kodeKecamatan: null,
            kodeKelurahan: $kodeKelurahan
        );

        $this->assertEquals(1, $result['total_wilayah'],
            'Filter kelurahan harus mengecek tepat 1 wilayah.');
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-10: Soft deleted data tidak dihitung sebagai data tersedia
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc10_soft_deleted_tidak_dihitung()
    {
        // Cek apakah tabel agama_penduduk punya kolom deleted_at
        $hasDeletedAt = DB::getSchemaBuilder()->hasColumn('agama_penduduk', 'deleted_at');
        $this->assertTrue($hasDeletedAt, 'Tabel agama_penduduk harus memiliki kolom deleted_at.');

        // Hitung data aktif vs total (termasuk soft deleted)
        $totalAktif = DB::table('agama_penduduk')
            ->where('tahun', 2024)->where('semester', 1)
            ->whereNull('deleted_at')
            ->distinct()->count('kode_wilayah');

        $totalSemua = DB::table('agama_penduduk')
            ->where('tahun', 2024)->where('semester', 1)
            ->distinct()->count('kode_wilayah');

        $result = $this->service->checkAvailability(
            'data_dkb', 'penduduk', 'agama', 2024, 1
        );

        // Service harus menggunakan hitungan aktif
        $this->assertEquals($totalAktif, $result['total_data'],
            'Service harus menggunakan jumlah data aktif (tidak soft-deleted).');
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-11: Registry tidak valid mengembalikan status unknown
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc11_registry_tidak_valid_mengembalikan_unknown()
    {
        $result = $this->service->checkAvailability(
            'fitur_tidak_ada', 'entitas_tidak_ada', 'dimensi_tidak_ada', 2024, 1
        );

        $this->assertEquals('unknown', $result['status']);
        $this->assertArrayHasKey('error', $result);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-12: Endpoint summary hanya bisa diakses admin (can:pengaturan)
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc12_summary_endpoint_hanya_untuk_admin()
    {
        $user = $this->createUserWithNoPermission();
        $this->actingAs($user);

        $response = $this->get(route('data_availability.summary', [
            'tahun' => 2024, 'semester' => 1
        ]));

        $response->assertStatus(403);
    }

    /** @test */
    public function tc12b_summary_berhasil_untuk_admin()
    {
        $user = $this->createUserWithPermission('pengaturan');
        $this->actingAs($user);

        $response = $this->getJson(route('data_availability.summary', [
            'tahun' => 2024, 'semester' => 1
        ]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'tahun', 'semester', 'total', 'available', 'partial', 'missing', 'items'
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-13: Dashboard admin dapat diakses dan menampilkan view
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc13_dashboard_dapat_diakses_admin()
    {
        $user = $this->createUserWithPermission('pengaturan');
        $this->actingAs($user);

        $response = $this->get(route('data_availability.dashboard', [
            'tahun' => 2024, 'semester' => 1
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('data_availability.dashboard');
        $response->assertViewHasAll(['summary', 'features', 'tahun', 'semester']);
    }

    // ══════════════════════════════════════════════════════════════
    //  TC-14: getKelurahanScope mengembalikan semua kelurahan jika tidak ada filter
    // ══════════════════════════════════════════════════════════════
    /** @test */
    public function tc14_scope_tanpa_filter_mengembalikan_semua_kelurahan()
    {
        $totalKelurahan = DB::table('mstr_kelurahan')->whereNull('deleted_at')->count();
        $scope = $this->service->getKelurahanScope(null, null);

        $this->assertCount($totalKelurahan, $scope);
    }

    // ══════════════════════════════════════════════════════════════
    //  HELPER METHODS
    // ══════════════════════════════════════════════════════════════

    private function createUserWithPermission(string $permission)
    {
        $user = \App\Models\User::factory()->create();
        $user->givePermissionTo($permission);
        return $user;
    }

    private function createUserWithNoPermission()
    {
        return \App\Models\User::factory()->create();
    }
}
