<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Boks;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Rak;
use Illuminate\Http\Request;
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

    public function search(Request $request): View
    {
        $validated = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $query = trim($validated['q'] ?? '');
        $results = collect();

        if ($query !== '') {
            $pattern = '%'.$query.'%';

            $results = $results->concat(Kecamatan::query()
                ->where('name', 'like', $pattern)
                ->withCount('kelurahans')
                ->limit(20)
                ->get()
                ->map(fn (Kecamatan $kecamatan) => [
                    'type' => 'Kecamatan',
                    'label' => $kecamatan->name,
                    'details' => $kecamatan->kelurahans_count.' kelurahan',
                    'href' => route('archives.kelurahans.index', $kecamatan),
                ]));

            $results = $results->concat(Kelurahan::query()
                ->where(fn ($builder) => $builder
                    ->where('name', 'like', $pattern)
                    ->orWhere('code', 'like', $pattern))
                ->with('kecamatan')
                ->limit(20)
                ->get()
                ->map(fn (Kelurahan $kelurahan) => [
                    'type' => 'Kelurahan',
                    'label' => $kelurahan->name.($kelurahan->code ? ' ('.$kelurahan->code.')' : ''),
                    'details' => 'Kecamatan '.$kelurahan->kecamatan->name,
                    'href' => route('archives.raks.index', $kelurahan),
                ]));

            $results = $results->concat(Rak::query()
                ->where(fn ($builder) => $builder
                    ->where('name', 'like', $pattern)
                    ->orWhere('location', 'like', $pattern)
                    ->orWhere('notes', 'like', $pattern))
                ->with('kelurahan.kecamatan')
                ->limit(20)
                ->get()
                ->map(fn (Rak $rak) => [
                    'type' => 'Rak',
                    'label' => $rak->name,
                    'details' => trim(collect([
                        $rak->location,
                        $rak->kelurahan->name,
                        $rak->kelurahan->kecamatan->name,
                    ])->filter()->implode(' · ')),
                    'href' => route('archives.boks.index', $rak),
                ]));

            $results = $results->concat(Boks::query()
                ->where(fn ($builder) => $builder
                    ->where('code', 'like', $pattern)
                    ->orWhere('year_start', 'like', $pattern)
                    ->orWhere('year_end', 'like', $pattern)
                    ->orWhere('description', 'like', $pattern))
                ->with('rak.kelurahan.kecamatan')
                ->limit(20)
                ->get()
                ->map(fn (Boks $boks) => [
                    'type' => 'Boks',
                    'label' => 'Boks '.$boks->code,
                    'details' => trim(collect([
                        $boks->description,
                        $boks->rak->name,
                        $boks->rak->kelurahan->name,
                        $boks->rak->kelurahan->kecamatan->name,
                    ])->filter()->implode(' · ')),
                    'href' => route('archives.arsips.index', $boks),
                ]));

            $results = $results->concat(Arsip::query()
                ->where(fn ($builder) => $builder
                    ->where('archive_number', 'like', $pattern)
                    ->orWhere('title', 'like', $pattern)
                    ->orWhere('document_type', 'like', $pattern)
                    ->orWhere('year', 'like', $pattern)
                    ->orWhere('description', 'like', $pattern)
                    ->orWhere('file_path', 'like', $pattern))
                ->with('boks.rak.kelurahan.kecamatan')
                ->limit(20)
                ->get()
                ->map(fn (Arsip $arsip) => [
                    'type' => 'Arsip',
                    'label' => $arsip->archive_number.' - '.$arsip->title,
                    'details' => trim(collect([
                        $arsip->document_type,
                        $arsip->year,
                        $arsip->description,
                        'Boks '.$arsip->boks->code,
                        $arsip->boks->rak->kelurahan->name,
                        $arsip->boks->rak->kelurahan->kecamatan->name,
                    ])->filter()->implode(' · ')),
                    'href' => route('archives.arsips.index', $arsip->boks),
                ]));
        }

        return view('archives.search', compact('query', 'results'));
    }

    public function kelurahans(Kecamatan $kecamatan): View
    {
        $kelurahans = $kecamatan->kelurahans()
            ->with(['raks.boks' => fn ($query) => $query->withCount('arsips')])
            ->orderBy('name')
            ->get()
            ->map(fn (Kelurahan $kelurahan) => [
                'name' => $kelurahan->name,
                'code' => $kelurahan->code,
                'archive_count' => $kelurahan->raks->sum(
                    fn (Rak $rak) => $rak->boks->sum('arsips_count')
                ),
                'href' => route('archives.raks.index', $kelurahan),
            ]);

        return view('archives.kelurahans', compact('kecamatan', 'kelurahans'));
    }

    public function raks(Kelurahan $kelurahan): View
    {
        // Load boks with arsips count so we can compute total arsip per rak
        $raks = $kelurahan->raks()
            ->with(['boks' => fn ($q) => $q->withCount('arsips')])
            ->withCount('boks')
            ->orderBy('name')
            ->get();

        $items = $raks->map(fn (Rak $rak) => [
            'label' => $rak->name,
            'subtitle' => trim(collect([$rak->location, $rak->boks_count.' boks'])->filter()->implode(' · ')),
            'count' => $rak->boks->sum(fn ($b) => $b->arsips_count ?? 0),
            'href' => route('archives.boks.index', $rak),
            'delete_url' => route('archives.raks.destroy', $rak),
        ])->all();

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

    public function storeRak(Request $request, Kelurahan $kelurahan)
    {

        $data = $request->validate([
            'nik' => ['nullable','string','max:64','unique:raks,nik'],
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $rak = $kelurahan->raks()->create([
            'nik' => $data['nik'] ?? null,
            'name' => $data['name'],
            'location' => $data['location'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'rak' => $rak]);
        }

        return redirect()->route('archives.raks.index', $kelurahan)->with('success', 'Rak berhasil dibuat');
    }

    public function destroyRak(Rak $rak)
    {
        // Optionally check permissions here
        $rak->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Rak dihapus');
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