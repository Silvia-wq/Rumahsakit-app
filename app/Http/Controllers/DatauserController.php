<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;    

class DatauserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }
    
    public function add(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'password' => 'required|string|min:6|confirmed',
            'no_telepon' => 'required|string|max:15',
            'foto_user' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required|in:admin,kepala_rs,petugas,pasien',
        ]);
    
        // Mengatur penyimpanan file foto_user jika ada
        $fileName = null;
        if ($request->hasFile('foto_user')) {
            $fileName = time().'.'.$request->foto_user->extension();
            $request->foto_user->storeAs('foto_user', $fileName, 'public');
        }
    
        // Menyimpan data user ke database
        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'foto_user' => $fileName,
            'roles' => $request->roles,
        ]);
    
        // Redirect ke halaman index user dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan!');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.update', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Validasi input
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|email|max:255|unique:users,username,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'no_telepon' => 'required|string|max:15',
            'roles' => 'required|in:admin,petugas,pasien',
            'foto_user' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Update data user
        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->no_telepon = $request->no_telepon;
        $user->roles = $request->roles;
    
        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        // Jika ada file foto baru, upload dan update
        if ($request->hasFile('foto_user')) {
            $file = $request->file('foto_user');
    
            // Hapus foto lama jika ada
            if ($user->foto_user && Storage::exists($user->foto_user)) {
                Storage::delete($user->foto_user);
            }
    
            // Simpan file baru dengan path otomatis
            $path = $file->store('public/foto_user');
            
            // Simpan path relatif ke database
            $user->foto_user = str_replace('public/', '', $path);
        }
    
        // Simpan perubahan
        $user->save();
    
        return redirect()->route('user.index')->with('success', 'Profil berhasil diperbarui!');
    }
    
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    
        // Hapus foto jika ada
        if ($user->foto_user) {
            Storage::disk('public')->delete('foto_user/'.$user->foto_user);
        }
    
        $user->delete();
    
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus!');
    }
}