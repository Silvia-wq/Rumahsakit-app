<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poliklinik = Poliklinik::latest()->get();
    return view('poliklinik.index', [
        'poliklinik' => $poliklinik
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('poliklinik.create');
    }

    public function add(Request $request)
{
    // Validasi data
    $validatedData = $request->validate([
        'nama_poliklinik' => 'required|max:255',
    ]);

    try {
        // Simpan data ke dalam database
        Poliklinik::create($validatedData);
        return redirect()->route('poliklinik.index')->with('success', 'Data berhasil disimpan!');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. Silakan coba lagi.']);
    }
}
public function edit($id)
{
    $poliklinik = Poliklinik::findOrFail($id);
    return view('poliklinik.update', ['poliklinik' => $poliklinik]);
}
public function update(Request $request, $id)
{
    // Validasi data
    $validatedData = $request->validate([
        'nama_poliklinik' => 'required|max:255',
    ]);

    try {
        // Cari dan update data
        $poliklinik = Poliklinik::findOrFail($id);
        $poliklinik->nama_poliklinik = $validatedData['nama_poliklinik'];
        $poliklinik->save();

        return redirect()->route('poliklinik.index')->with('success', 'Data berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data. Silakan coba lagi.']);
    }
}
public function destroy($id)
{
    try {
        $poliklinik = Poliklinik::findOrFail($id);
        $poliklinik->delete();

        return redirect()->route('poliklinik.index')->with('success', 'Data berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Gagal menghapus data. Silakan coba lagi.']);
    }
}
}