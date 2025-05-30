<?php

namespace App\Http\Controllers;
use App\Models\Dokter;
use App\Models\Jadwalpoliklinik;
use App\Models\Poliklinik;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class JadwalpoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Query untuk mengambil data jadwal poliklinik
        $jadwalpoliklinik = Jadwalpoliklinik::orderBy('created_at', 'desc')->get();

        // Ambil parameter dari permintaan GET
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Inisialisasi query untuk semua data jadwal poliklinik
        $query = Jadwalpoliklinik::query();

        // Filter berdasarkan rentang tanggal jika parameter ada
        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_praktek', [$start_date, $end_date]);
        }

        // Ambil data jadwal poliklinik sesuai dengan query yang dibuat
        $jadwalpoliklinik = $query->orderBy('tanggal_praktek', 'asc')->get();

        return view('jadwalpoliklinik.index', compact('jadwalpoliklinik'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dokter = Dokter::all();
        return view('jadwalpoliklinik.create', compact('dokter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $request->validate([
            'dokter_id'      => 'required|exists:dokter,id',
            'tanggal_praktek' => 'required|date',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'jumlah'         => 'required|integer|min:1',
        ]);
    
        $jadwalPoliklinik = new Jadwalpoliklinik();
        $jadwalPoliklinik->dokter_id = $request->dokter_id;
        $jadwalPoliklinik->poliklinik_id = Dokter::find($request->dokter_id)->poliklinik_id;
        $jadwalPoliklinik->tanggal_praktek = $request->tanggal_praktek;
        $jadwalPoliklinik->jam_mulai = $request->jam_mulai;
        $jadwalPoliklinik->jam_selesai = $request->jam_selesai;
        $jadwalPoliklinik->jumlah = $request->jumlah;
        $jadwalPoliklinik->save();
    
        return redirect()->route('jadwalpoliklinik.index')->with('success', 'berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jadwalpoliklinik = Jadwalpoliklinik::findOrFail($id);
        $dokter = Dokter::all();
        return view('jadwalpoliklinik.update', compact('jadwalpoliklinik', 'dokter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'tanggal_praktek' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jumlah' => 'required|integer|min:1',
        ]);
    
        $jadwalpoliklinik = Jadwalpoliklinik::findOrFail($id);
        $jadwalpoliklinik->dokter_id = $request->dokter_id;
        $jadwalpoliklinik->poliklinik_id = Dokter::find($request->dokter_id)->poliklinik_id;
        $jadwalpoliklinik->tanggal_praktek = $request->tanggal_praktek;
        $jadwalpoliklinik->jam_mulai = $request->jam_mulai;
        $jadwalpoliklinik->jam_selesai = $request->jam_selesai;
        $jadwalpoliklinik->jumlah = $request->jumlah;
        $jadwalpoliklinik->save();
    
        return redirect()->route('jadwalpoliklinik.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwalpoliklinik = Jadwalpoliklinik::findOrFail($id);
        $jadwalpoliklinik->delete();
    
        return redirect()->route('jadwalpoliklinik.index')->with('success', 'Data berhasil dihapus');
    }
}