<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLayananRequest;
use App\Http\Requests\UpdateLayananRequest;
use App\Models\Layanan;
use App\Services\FotoStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function index(): View
    {
        $layanans = Layanan::withCount('pricelists')->get();

        return view('admin.layanan.kategori', compact('layanans'));
    }

    public function store(StoreLayananRequest $request, FotoStorage $foto): RedirectResponse
    {
        $data = $request->safe()->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $foto->simpan($request->file('foto'), 'layanan');
        }

        Layanan::create($data);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(UpdateLayananRequest $request, Layanan $layanan, FotoStorage $foto): RedirectResponse
    {
        $data = $request->safe()->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $foto->ganti($layanan->foto, $request->file('foto'), 'layanan');
        }

        $layanan->update($data);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }
}