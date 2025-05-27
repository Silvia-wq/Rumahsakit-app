<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;    
use App\Models\Datapasien;    
use App\Models\JadwalPoliklinik;
use Carbon\Carbon;
use App\Models\Pendaftaran;
use App\Models\Antrian;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $now = Carbon::now()->setTimezone('Asia/Jakarta');
    
        // Ambil jadwal untuk hari ini yang belum lewat waktu sekarang
        $jadwalHariIni = Jadwalpoliklinik::with('dokter')
            ->whereDate('tanggal_praktek', $today)
            ->where('jam_selesai', '>', $now->format('H:i'))
            ->get();
    
        $tomorrow = Carbon::tomorrow();
        $jadwalBesok = Jadwalpoliklinik::with('dokter')
            ->whereDate('tanggal_praktek', $tomorrow)
            ->get();
    
        return view('pendaftaran.index', compact('today', 'tomorrow', 'jadwalHariIni', 'jadwalBesok'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $path = null; // Default value
        $datapasien = null; // Inisialisasi $datapasien di awal
    
        if ($user->roles == 'admin' || $user->roles == 'petugas') {
            $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'penjamin' => 'required',
                'no_telp' => 'nullable|regex:/^[0-9]+$/|max:15',
            ]);
            $nama_pasien = $request->nama_pasien;
            $id_pasien = null;
            $no_telp = $request->no_telp;
            
            // Jika admin/petugas memilih pasien yang sudah terdaftar, bisa ambil datanya
            if ($request->filled('id_pasien')) {
                $datapasien = Datapasien::find($request->id_pasien);
            }
        } else {
            $datapasien = Datapasien::where('user_id', $user->id)->first();
            if (!$datapasien) {
                return back()->withErrors(['msg' => 'Data pasien tidak ditemukan.']);
            }
    
            $requiredFields = [
                'nik', 'nama_pasien', 'email', 'no_telp',
                'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                'alamat', 'scan_ktp', 'no_kberobat', 'scan_kberobat'
            ];
            foreach ($requiredFields as $field) {
                if (empty($datapasien->$field)) {
                    return back()->withErrors(['msg' => 'Data diri pasien belum lengkap. Harap lengkapi semua data sebelum mendaftar.']);
                }
            }
    
            $request->validate([
                'penjamin' => 'required',
                'scan_surat_rujukan' => 'required_if:penjamin,BPJS|file|mimes:jpeg,png,pdf',
            ]);
    
            if ($request->penjamin === 'BPJS' && (empty($datapasien->no_kbpjs) || empty($datapasien->scan_kbpjs))) {
                return back()->withErrors(['msg' => 'Data BPJS belum lengkap, harap lengkapi data BPJS terlebih dahulu!']);
            }
    
            if ($request->penjamin === 'Asuransi' && empty($datapasien->scan_kasuransi)) {
                return back()->withErrors(['msg' => 'Data Asuransi belum lengkap, harap lengkapi data Asuransi terlebih dahulu!']);
            }
    
            $nama_pasien = $datapasien->nama_pasien;
            $id_pasien = $datapasien->id;
            $no_telp = $datapasien->no_telp;
        }
    
        $jadwalpoliklinik = Jadwalpoliklinik::findOrFail($request->jadwalpoliklinik_id);
        if ($jadwalpoliklinik->jumlah <= 0) {
            return back()->withErrors(['msg' => 'Kuota pendaftaran habis']);
        }
    
        if ($request->hasFile('scan_surat_rujukan')) {
            $file = $request->file('scan_surat_rujukan');
            $path = $file->store('public/surat_rujukan');
        }
    
        $jadwalpoliklinik->decrement('jumlah');
    
        $pendaftaran = new Pendaftaran();
        $pendaftaran->jadwalpoliklinik_id = $jadwalpoliklinik->id;
        $pendaftaran->penjamin = $request->penjamin;
        $pendaftaran->nama_pasien = $nama_pasien;
        $pendaftaran->id_pasien = $id_pasien;
        $pendaftaran->scan_surat_rujukan = $path;
        $pendaftaran->save();        
    
        $no_antrian = Antrian::where('jadwalpoliklinik_id', $jadwalpoliklinik->id)->count() + 1;
        $kode_antrian = $jadwalpoliklinik->poliklinik_id . $jadwalpoliklinik->dokter_id . $jadwalpoliklinik->id . $pendaftaran->id
            . $user->id . $no_antrian;
    
        // Get the kode value from jadwalpoliklinik table as kode_jadwalpoliklinik
        $kode_jadwal = isset($jadwalpoliklinik->kode) ? $jadwalpoliklinik->kode : 'JP' . $jadwalpoliklinik->id;
    
        Antrian::create([
            'kode_antrian' => $kode_antrian,
            'no_antrian' => $no_antrian,
            'kode_jadwalpoliklinik' => $kode_jadwal,
            'nama_pasien' => $nama_pasien,
            'no_telp' => $no_telp,
            'jadwalpoliklinik_id' => $jadwalpoliklinik->id,
            'id_pasien' => $id_pasien,
            'nama_dokter' => optional($jadwalpoliklinik->dokter)->nama_dokter,
            'poliklinik' => optional($jadwalpoliklinik->poliklinik)->nama_poliklinik,
            'penjamin' => $request->penjamin,
            'no_kbpjs' => $request->penjamin === 'BPJS' ? optional($datapasien)->no_kbpjs : null,
            'scan_kbpjs' => $request->penjamin === 'BPJS' ? optional($datapasien)->scan_kbpjs : null,
            'scan_kasuransi' => $request->penjamin === 'Asuransi' ? optional($datapasien)->scan_kasuransi : null,
            'tanggal_berobat' => $jadwalpoliklinik->tanggal_praktek,
            'tanggal_reservasi' => now(),
            'user_id' => $user->id,
            'scan_surat_rujukan' => $path,
        ]);
    
        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil');
    }
}