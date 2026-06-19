<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;

class AdminSpesialisasiController extends Controller
{
    public function index()
    {
        $spesialisasis = Spesialisasi::all();
        return view('admin.spesialisasi.index', compact('spesialisasis'));
    }

    public function create()
    {
        return view('admin.spesialisasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
        ]);

        Spesialisasi::create($request->all());

        return redirect()->route('admin.spesialisasi.index')->with('success', 'Spesialisasi berhasil ditambahkan');
    }

    public function show(Spesialisasi $spesialisasi)
    {
        return redirect()->route('admin.spesialisasi.index');
    }

    public function edit(Spesialisasi $spesialisasi)
    {
        return view('admin.spesialisasi.edit', compact('spesialisasi'));
    }

    public function update(Request $request, Spesialisasi $spesialisasi)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
        ]);

        $spesialisasi->update($request->all());

        return redirect()->route('admin.spesialisasi.index')->with('success', 'Spesialisasi berhasil diperbarui');
    }

    public function destroy(Spesialisasi $spesialisasi)
    {
        // Check if there are doctors linked to this specialization
        if ($spesialisasi->dokters()->count() > 0) {
            return redirect()->route('admin.spesialisasi.index')->with('error', 'Spesialisasi tidak bisa dihapus karena masih digunakan oleh dokter');
        }

        $spesialisasi->delete();
        return redirect()->route('admin.spesialisasi.index')->with('success', 'Spesialisasi berhasil dihapus');
    }
}
