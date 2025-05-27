<?php

namespace App\Http\Controllers;
use App\Models\User;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); // Mengambil data pengguna yang sedang login
        return view('user.profile', compact('user'));
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
        //
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
        //
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
        $user = User::findOrFail($id);
    
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|email|max:255|unique:user,username,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'no_telepon' => 'required|string|max:15',
            'foto_user' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->no_telepon = $request->no_telepon;
    
        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        if ($request->hasFile('foto_user')) {
            $file = $request->file('foto_user');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage
            $file->storeAs('public/foto_user', $filename);
            
            // Debug: Cek apakah file berhasil disimpan
            if (!Storage::exists('public/foto_user/' . $filename)) {
                return back()->with('error', 'Gagal menyimpan foto.');
            }
        
            // Hapus foto lama jika ada
            if ($user->foto_user) {
                Storage::delete('public/foto_user/' . $user->foto_user);
            }
        
            $user->foto_user = $filename;
        }    
        
        $user->save();

        if ($user->wasChanged()) {
            return redirect()->route('dashboard-' . Auth::user()->roles)
                ->with('success', 'Profil berhasil diperbarui!');
        }       
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}