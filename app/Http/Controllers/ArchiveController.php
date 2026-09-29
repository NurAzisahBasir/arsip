<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Boks;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Rak;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function index(): View
    {
        $kecamatans = Kecamatan::query()
            ->withCount('kelurahans')
            ->orderBy('name')
            ->get();

        return view('dashboard', compact('kecamatans'));
    }

    public function kelurahans(Kecamatan $kecamatan): View
    {
        $items = $kecamatan->kelurahans()
            ->withCount('raks')
            ->orderBy('name')
            ->get()
            ->map(fn (Kelurahan $kelurahan) => [
                'label' => $kelurahan->name,
                'subtitle' => trim(collect([
                    $kelurahan->code ? 'Kode '.$kelurahan->code : null,
                    $kelurahan->raks_count.' rak',
                ])->filter()->implode(' · ')),
                'href' => route('archives.raks.index', $kelurahan),
            ])
            ->all();

        return $this->listing(
            'Daftar Kelurahan',
            $kecamatan->name,
            [['label' => 'Kecamatan', 'href' => route('dashboard')]],
            $items,
            'Belum ada kelurahan pada kecamatan ini.'
        );
    }

    public function raks(Kelurahan $kelurahan): View
    {
        $items = $kelurahan->raks()
            ->withCount('boks')
            ->orderBy('name')
            ->get()
            ->map(fn (Rak $rak) => [
                'label' => $rak->name,
                'subtitle' => trim(collect([$rak->location, $rak->boks_count.' boks'])->filter()->implode(' · ')),
                'href' => route('archives.boks.index', $rak),
            ])
            ->all();

        return $this->listing(
            'Daftar Rak',
            $kelurahan->name,
            [
                ['label' => 'Kecamatan', 'href' => route('dashboard')],
                ['label' => $kelurahan->kecamatan->name, 'href' => route('archives.kelurahans.index', $kelurahan->kecamatan)],
            ],
            $items,
            'Belum ada rak pada kelurahan ini.'
        );
    }

    public function boks(Rak $rak): View
    {
        $items = $rak->boks()
            ->withCount('arsips')
            ->orderBy('code')
            ->get()
            ->map(fn (Boks $boks) => [
                'label' => 'Boks '.$boks->code,
                'subtitle' => trim(collect([
                    $boks->year_start && $boks->year_end
                        ? $boks->year_start.'-'.$boks->year_end
                        : ($boks->year_start ?? $boks->year_end),
                    $boks->arsips_count.' arsip',
                ])->filter()->implode(' · ')),
                'href' => route('archives.arsips.index', $boks),
            ])
            ->all();

        $kelurahan = $rak->kelurahan;
        $kecamatan = $kelurahan->kecamatan;

        return $this->listing(
            'Daftar Boks',
            $rak->name,
            [
                ['label' => 'Kecamatan', 'href' => route('dashboard')],
                ['label' => $kecamatan->name, 'href' => route('archives.kelurahans.index', $kecamatan)],
                ['label' => $kelurahan->name, 'href' => route('archives.raks.index', $kelurahan)],
            ],
            $items,
            'Belum ada boks pada rak ini.'
        );
    }

    public function arsips(Boks $boks): View
    {
        $items = $boks->arsips()
            ->orderBy('archive_number')
            ->get()
            ->map(fn (Arsip $arsip) => [
                'label' => $arsip->archive_number.' - '.$arsip->title,
                'subtitle' => trim(collect([$arsip->document_type, $arsip->year])->filter()->implode(' · ')),
                'href' => null,
            ])
            ->all();

        $rak = $boks->rak;
        $kelurahan = $rak->kelurahan;
        $kecamatan = $kelurahan->kecamatan;

        return $this->listing(
            'Daftar Arsip',
            'Boks '.$boks->code,
            [
                ['label' => 'Kecamatan', 'href' => route('dashboard')],
                ['label' => $kecamatan->name, 'href' => route('archives.kelurahans.index', $kecamatan)],
                ['label' => $kelurahan->name, 'href' => route('archives.raks.index', $kelurahan)],
                ['label' => $rak->name, 'href' => route('archives.boks.index', $rak)],
            ],
            $items,
            'Belum ada arsip pada boks ini.'
        );
    }

    private function listing(string $title, string $context, array $breadcrumbs, array $items, string $emptyMessage): View
    {
        return view('archives.list', compact('title', 'context', 'breadcrumbs', 'items', 'emptyMessage'));
    }
}