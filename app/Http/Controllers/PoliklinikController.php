<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;

class PoliklinikController extends Controller
{

    public function index()
    {
        $poliklinik = Poliklinik::latest()->get();
        return view('poliklinik.index', [
            'poliklinik' => $poliklinik
        ]);
    }

    public function create()
    {
        return view('poliklinik.create');
    }

    public function store(Request $request)
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

    public function show($id)
    {
        //
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

        // Cari poliklinik berdasarkan ID
        $poliklinik = Poliklinik::findOrFail($id);

        // Update data poliklinik
        $poliklinik->nama_poliklinik = $validatedData['nama_poliklinik'];
        $poliklinik->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('poliklinik.index')->with('success', 'Data berhasil diperbarui!');
    }


    public function destroy($id)
    {
        try {
            $poliklinik = Poliklinik::findOrFail($id);
            $poliklinik->delete();
    
            return redirect()->route('poliklinik.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data!']);
        }
    }
    
}