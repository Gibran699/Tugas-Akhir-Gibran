<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya insert jika tabel masih kosong
        if (DB::table('mstr_kecamatan')->count() > 0) {
            return;
        }

        DB::table('mstr_kecamatan')->insert([
            ['id' => 1,  'uuid' => '87ee32ac-f358-4f9d-87b4-48bb3691a0b1', 'kode' => 647201, 'nama' => 'PALARAN',           'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 2,  'uuid' => '812e9dac-dfc6-47b5-b232-ad4361034da1', 'kode' => 647204, 'nama' => 'SAMARINDA ILIR',    'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 3,  'uuid' => 'd311f592-7f66-4d23-b6f1-c00d2d069cd9', 'kode' => 647209, 'nama' => 'SAMARINDA KOTA',    'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 4,  'uuid' => '41c7fef7-ade0-45ee-bb33-334edb644b01', 'kode' => 647207, 'nama' => 'SAMBUTAN',           'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 5,  'uuid' => '23c01dc0-b664-4277-a94d-9259a6332cd9', 'kode' => 647202, 'nama' => 'SAMARINDA SEBERANG', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 6,  'uuid' => '1ead0bf8-e2f8-4708-88fc-cd3861c1013f', 'kode' => 647210, 'nama' => 'LOA JANAN ILIR',    'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 7,  'uuid' => '5f6c838e-a986-4dd8-8eaf-9ab3e1bbc7e8', 'kode' => 647206, 'nama' => 'SUNGAI KUNJANG',    'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 8,  'uuid' => 'e63cba7a-3a03-4583-a6f8-5a58e5e25998', 'kode' => 647203, 'nama' => 'SAMARINDA ULU',     'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 9,  'uuid' => '0c086e52-5f8c-4621-9361-bd7f63b19558', 'kode' => 647205, 'nama' => 'SAMARINDA UTARA',   'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 10, 'uuid' => '32d6ef2b-339f-40ce-9cde-af2012f3fb0c', 'kode' => 647208, 'nama' => 'SUNGAI PINANG',     'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
        ]);

        DB::table('mstr_kelurahan')->insert([
            ['id' => 1,  'uuid' => 'f5604a42-de25-4bc6-8cd0-379c25d9991a', 'kode' => 6472011004, 'nama' => 'SIMPANG PASIR',       'kec_id' => 647201, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 2,  'uuid' => '8fdfc078-2c29-41b3-a4dd-45f2e8692d92', 'kode' => 6472011002, 'nama' => 'HANDIL BAKTI',        'kec_id' => 647201, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 3,  'uuid' => 'a11e52c8-6a88-4904-811c-7be8323d0889', 'kode' => 6472011005, 'nama' => 'BANTUAS',             'kec_id' => 647201, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 4,  'uuid' => '958ce0b6-320d-4f2a-8681-824f8cbbd653', 'kode' => 6472011003, 'nama' => 'BUKUAN',              'kec_id' => 647201, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 5,  'uuid' => 'df6729a3-795d-4e01-9e24-019dd8db1e15', 'kode' => 6472011001, 'nama' => 'RAWA MAKMUR',        'kec_id' => 647201, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 6,  'uuid' => '9a8c765a-ee05-42c1-bc48-a42787cca2f7', 'kode' => 6472041001, 'nama' => 'SELILI',             'kec_id' => 647204, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 7,  'uuid' => '4a55560a-6ce9-4542-b56f-c02d34188f6c', 'kode' => 6472041002, 'nama' => 'SUNGAI DAMA',        'kec_id' => 647204, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 8,  'uuid' => 'd436b037-78e5-43e2-82b1-654279f44789', 'kode' => 6472041003, 'nama' => 'SIDODAMAI',          'kec_id' => 647204, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 9,  'uuid' => '8fd6d6b4-241a-4bb9-84df-83d1e852fe0e', 'kode' => 6472041013, 'nama' => 'SIDOMULYO',          'kec_id' => 647204, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 10, 'uuid' => '28627586-e605-43bb-803a-ebd26ae6c186', 'kode' => 6472041014, 'nama' => 'PELITA',             'kec_id' => 647204, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 11, 'uuid' => '9699c172-dfce-422f-a566-aab7f75ba784', 'kode' => 6472091004, 'nama' => 'BUGIS',              'kec_id' => 647209, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 12, 'uuid' => 'a1844b3d-7e22-4d4f-b9f1-a61854b0887a', 'kode' => 6472091003, 'nama' => 'PASAR PAGI',        'kec_id' => 647209, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 13, 'uuid' => '2bc6c6d3-6a20-47c9-b40d-3bc158e0cb9c', 'kode' => 6472091002, 'nama' => 'PELABUHAN',         'kec_id' => 647209, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 14, 'uuid' => '10f84348-8d70-46dc-914b-6040ecfbb353', 'kode' => 6472091005, 'nama' => 'SUNGAI PINANG LUAR', 'kec_id' => 647209, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 15, 'uuid' => 'cd3a2bfe-b196-4bfb-89b3-8a58d6b0d7c3', 'kode' => 6472091001, 'nama' => 'KARANG MUMUS',      'kec_id' => 647209, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 16, 'uuid' => 'c21b249e-652e-4988-9623-23ac3261a4b3', 'kode' => 6472071005, 'nama' => 'PULAU ATAS',         'kec_id' => 647207, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 17, 'uuid' => 'f880c030-d09a-4064-8e15-03f2af9bf4cf', 'kode' => 6472071004, 'nama' => 'SINDANG SARI',      'kec_id' => 647207, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 18, 'uuid' => '67dd9fb7-daec-48f2-b0a7-6ba58b86f75e', 'kode' => 6472071003, 'nama' => 'MAKROMAN',          'kec_id' => 647207, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 19, 'uuid' => 'a18c5b1a-0190-49a7-b51a-a33ce058f8eb', 'kode' => 6472071002, 'nama' => 'SAMBUTAN',          'kec_id' => 647207, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 20, 'uuid' => '8956105a-fd18-4c1e-9b69-8f5c69360983', 'kode' => 6472071001, 'nama' => 'SUNGAI KAPIH',      'kec_id' => 647207, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 21, 'uuid' => '646f3d36-6a28-4d0a-8f66-d70889d9f955', 'kode' => 6472021003, 'nama' => 'MESJID',            'kec_id' => 647202, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 22, 'uuid' => '3a89e309-aa3f-4834-9695-1c0f5794290a', 'kode' => 6472021002, 'nama' => 'BAQA',              'kec_id' => 647202, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 23, 'uuid' => '33070db8-2d90-41fc-9676-7853c034ff7a', 'kode' => 6472021001, 'nama' => 'SUNGAI KELEDANG',   'kec_id' => 647202, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 24, 'uuid' => '342831c0-6149-404f-a609-34235a1e4807', 'kode' => 6472021009, 'nama' => 'MANGKUPALAS',       'kec_id' => 647202, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 25, 'uuid' => '714ae25a-d4d9-4927-90dc-e39fa1aac757', 'kode' => 6472021010, 'nama' => 'TENUN SAMARINDA',   'kec_id' => 647202, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 26, 'uuid' => '14390e80-b68a-4241-9132-4d57c64dac51', 'kode' => 6472021011, 'nama' => 'GUNUNG PANJANG',    'kec_id' => 647202, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 27, 'uuid' => 'a933b272-94d7-4168-853e-f2b94ceb7fac', 'kode' => 6472101003, 'nama' => 'SENGKOTEK',         'kec_id' => 647210, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 28, 'uuid' => '5e457830-37ec-41b5-8d9e-f3bfd587dda7', 'kode' => 6472101001, 'nama' => 'SIMPANG TIGA',      'kec_id' => 647210, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 29, 'uuid' => '16b86e27-2f5c-40f7-afcb-cfbebacac514', 'kode' => 6472101002, 'nama' => 'TANI AMAN',         'kec_id' => 647210, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 30, 'uuid' => '7f64ca35-1164-457f-9907-20f513952c39', 'kode' => 6472101004, 'nama' => 'HARAPAN BARU',      'kec_id' => 647210, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 31, 'uuid' => '0260aa37-ea5b-4ecc-8d46-254778522371', 'kode' => 6472101005, 'nama' => 'RAPAK DALAM',       'kec_id' => 647210, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 32, 'uuid' => '81a4387d-a08e-4ed1-8ba7-fb4b8265bbc5', 'kode' => 6472061002, 'nama' => 'LOA BUAH',          'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 33, 'uuid' => 'cbc1fd01-35be-4b37-bb17-2b1174d3c8c7', 'kode' => 6472061001, 'nama' => 'LOA BAKUNG',        'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 34, 'uuid' => 'c1f80dc1-3a6d-43c0-b21c-3c777b92833e', 'kode' => 6472061003, 'nama' => 'KARANG ASAM ULU',  'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 35, 'uuid' => 'e1ede053-c1a1-4d77-a64b-167091e335a0', 'kode' => 6472061005, 'nama' => 'TELUK LERONG ULU', 'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 36, 'uuid' => '73a4f038-7542-4ff4-ad14-7d29cc9f6f60', 'kode' => 6472061004, 'nama' => 'LOK BAHU',          'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 37, 'uuid' => 'e7afa588-c5eb-478b-97e0-d5fb8501d0bb', 'kode' => 6472061006, 'nama' => 'KARANG ASAM ILIR', 'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 38, 'uuid' => '0dfc1fcf-fbcb-45b7-b4e5-82a177a5c75b', 'kode' => 6472061007, 'nama' => 'KARANG ANYAR',     'kec_id' => 647206, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 39, 'uuid' => 'aaa400b4-848b-4eb9-bdb4-91a8be0ee38b', 'kode' => 6472031001, 'nama' => 'TELUK LERONG ILIR', 'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 40, 'uuid' => '2def04f0-dcfd-46f6-bf49-6ae60b7748b9', 'kode' => 6472031002, 'nama' => 'JAWA',              'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 41, 'uuid' => '6f92573b-f0fc-4a95-8035-65f184f363de', 'kode' => 6472031007, 'nama' => 'DADIMULYA',         'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 42, 'uuid' => 'ec8f01a3-1117-4723-9f3f-988a61ff5ca8', 'kode' => 6472031005, 'nama' => 'SIDODADI',          'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 43, 'uuid' => 'f7d7f1af-b150-4660-84ab-20082cb166e3', 'kode' => 6472031008, 'nama' => 'GUNUNG KELUA',      'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 44, 'uuid' => '1fdaf2fe-1f2b-4617-b77f-d8abcb2beebe', 'kode' => 6472031006, 'nama' => 'AIR HITAM',         'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 45, 'uuid' => 'e13c5746-e6f8-4984-b16d-0b7f8001e707', 'kode' => 6472031004, 'nama' => 'AIR PUTIH',         'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 46, 'uuid' => 'd8d49738-82c3-4060-bbfa-e3b628a8252b', 'kode' => 6472031009, 'nama' => 'BUKIT PINANG',      'kec_id' => 647203, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 47, 'uuid' => 'a2698612-92ea-4b79-aa66-116922281655', 'kode' => 6472051003, 'nama' => 'LEMPAKE',           'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 48, 'uuid' => '50565bcc-701b-4d70-855d-1ed13613729f', 'kode' => 6472051002, 'nama' => 'SEMPAJA SELATAN',   'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 49, 'uuid' => '14d81e17-00d1-45aa-9290-27c4f2a7bd5b', 'kode' => 6472051004, 'nama' => 'SUNGAI SIRING',    'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 50, 'uuid' => '68c7f947-f5e4-41c1-b773-0f5eaa50b245', 'kode' => 6472051011, 'nama' => 'TANAH MERAH',      'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 51, 'uuid' => '97501735-6d9f-4737-bbbd-29c1693f44de', 'kode' => 6472051010, 'nama' => 'SEMPAJA UTARA',    'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 52, 'uuid' => '6a87f22b-2527-4b22-af36-ca8dbbefd485', 'kode' => 6472051013, 'nama' => 'SEMPAJA TIMUR',    'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 53, 'uuid' => 'd3bebc1f-f38f-4e19-a759-469044bd0cd7', 'kode' => 6472051012, 'nama' => 'SEMPAJA BARAT',    'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 54, 'uuid' => '41ec06a6-e45f-40a0-a406-fc277fca4aa1', 'kode' => 6472051014, 'nama' => 'BUDAYA PAMPANG',   'kec_id' => 647205, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 55, 'uuid' => '419e4fd9-d857-46d9-89d6-5dc24490a201', 'kode' => 6472081001, 'nama' => 'TEMINDUNG PERMAI', 'kec_id' => 647208, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 56, 'uuid' => '8bfd1b9e-0461-4776-a5e7-9d356bd465d6', 'kode' => 6472081005, 'nama' => 'BANDARA',           'kec_id' => 647208, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 57, 'uuid' => 'd9677e9e-4464-40a9-87ef-8d8c8c10a194', 'kode' => 6472081002, 'nama' => 'SUNGAI PINANG DALAM', 'kec_id' => 647208, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 58, 'uuid' => '922ac11d-5bbe-4e8f-836d-0c5a855ef693', 'kode' => 6472081004, 'nama' => 'MUGIREJO',          'kec_id' => 647208, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 59, 'uuid' => '172e5eeb-886c-4d9c-8ded-c754809d7cdc', 'kode' => 6472081003, 'nama' => 'GUNUNG LINGAI',    'kec_id' => 647208, 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
        ]);
    }
}
