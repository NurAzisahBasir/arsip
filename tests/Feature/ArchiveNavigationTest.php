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
        $this->get(route('archives.kelurahans.index', $kecamatan))->assertOk()->assertSee('Sumpang Minangae');
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
}