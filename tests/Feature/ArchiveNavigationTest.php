<?php

namespace Tests\Feature;

use App\Models\Arsip;
use App\Models\Boks;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Rak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArchiveNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_browse_archives_from_kecamatan_to_records(): void
    {
        $this->actingAs(User::factory()->create());

        $kecamatan = Kecamatan::create(['name' => 'Bacukiki']);
        $kelurahan = Kelurahan::create(['kecamatan_id' => $kecamatan->id, 'name' => 'Sumpang Minangae']);
        $rak = Rak::create(['kelurahan_id' => $kelurahan->id, 'name' => 'Rak A']);
        $boks = Boks::create(['rak_id' => $rak->id, 'code' => 'Boks-001']);
        Arsip::create([
            'boks_id' => $boks->id,
            'archive_number' => '001',
            'title' => 'Kartu Keluarga',
            'document_type' => 'KK',
            'year' => 2024,
        ]);

        $this->get(route('dashboard'))->assertOk()->assertSee('Kec. Bacukiki');
        $this->get(route('archives.kelurahans.index', $kecamatan))
            ->assertOk()
            ->assertSee('Kel. Sumpang Minangae')
            ->assertSee('1 Arsip')
            ->assertSee('Cari Kelurahan...')
            ->assertSee('Lihat Arsip');
        $this->get(route('archives.raks.index', $kelurahan))->assertOk()->assertSee('Rak A');
        $this->get(route('archives.boks.index', $rak))->assertOk()->assertSee('Boks Boks-001');
        $this->get(route('archives.arsips.index', $boks))->assertOk()->assertSee('Kartu Keluarga');
    }

    public function test_seeded_kelurahan_codes_are_shown_under_their_kecamatan(): void
    {
        $this->seed();
        $this->actingAs(User::factory()->create());

        $kecamatan = Kecamatan::where('name', 'Bacukiki')->firstOrFail();

        $this->get(route('archives.kelurahans.index', $kecamatan))
            ->assertOk()
            ->assertSee('Lompoe')
            ->assertSee('Kode 1004')
            ->assertSee('Galung Maloang')
            ->assertSee('Kode 1010');
    }

    public function test_global_search_finds_locations_boxes_and_all_archive_fields(): void
    {
        $this->actingAs(User::factory()->create());

        $kecamatan = Kecamatan::create(['name' => 'Kecamatan Contoh']);
        $kelurahan = Kelurahan::create([
            'kecamatan_id' => $kecamatan->id,
            'name' => 'Kelurahan Uji',
            'code' => '1099',
        ]);
        $rak = Rak::create([
            'kelurahan_id' => $kelurahan->id,
            'name' => 'Rak Rahasia',
            'location' => 'Ruang Mawar',
            'notes' => 'Catatan rak unik',
        ]);
        $boks = Boks::create([
            'rak_id' => $rak->id,
            'code' => 'BOX-XY77',
            'year_start' => 2020,
            'year_end' => 2024,
            'description' => 'Deskripsi boks khusus',
        ]);
        Arsip::create([
            'boks_id' => $boks->id,
            'archive_number' => 'ARS-7788',
            'title' => 'Judul Berkas Khusus',
            'document_type' => 'FORM-UNIK',
            'year' => 2023,
            'description' => 'Keterangan arsip istimewa',
            'file_path' => 'dokumen/lokasi-unik.pdf',
        ]);

        foreach ([
            'Kecamatan Contoh' => 'Kecamatan Contoh',
            '1099' => 'Kelurahan Uji (1099)',
            'Ruang Mawar' => 'Rak Rahasia',
            'BOX-XY77' => 'Boks BOX-XY77',
            '2024' => 'Boks BOX-XY77',
            'Deskripsi boks khusus' => 'Boks BOX-XY77',
            'ARS-7788' => 'ARS-7788 - Judul Berkas Khusus',
            'FORM-UNIK' => 'ARS-7788 - Judul Berkas Khusus',
            '2023' => 'ARS-7788 - Judul Berkas Khusus',
            'Keterangan arsip istimewa' => 'ARS-7788 - Judul Berkas Khusus',
            'lokasi-unik.pdf' => 'ARS-7788 - Judul Berkas Khusus',
        ] as $query => $expected) {
            $this->get(route('archives.search', ['q' => $query]))
                ->assertOk()
                ->assertSee($expected);
        }
    }
}