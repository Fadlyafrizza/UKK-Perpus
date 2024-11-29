<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\kategoriBuku;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    use UserTrait;

    public function index(Request $Fadly_request)
    {

        $Fadly_search = $Fadly_request->input('search');

        $Fadly_buku = Buku::with(['kategori', 'ulasan', 'peminjaman'])
                        ->when($Fadly_search, function($query, $Fadly_search) {
                            return $query->where('Judul', 'like', "%{$Fadly_search}%")
                                         ->orWhere('Penulis', 'like', "%{$Fadly_search}%")
                                         ->orWhere('Penerbit', 'like', "%{$Fadly_search}%");
                        })->get();

        return view('buku.index', [
            'buku' => $Fadly_buku,
            'search' => $Fadly_search
        ]);
    }

    public function store(Request $Fadly_request)
    {
        $Fadly_validate = $Fadly_request->validate([
            'Judul' => 'required|string|max:255',
            'Penulis' => 'required|string|max:255',
            'Penerbit' => 'required|string|max:255',
            'TahunTerbit' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'kategori' => 'array',
        ]);

        $Fadly_buku = Buku::create([
            'Judul' => $Fadly_validate['Judul'],
            'Penulis' => $Fadly_validate['Penulis'],
            'Penerbit' => $Fadly_validate['Penerbit'],
            'TahunTerbit' => $Fadly_validate['TahunTerbit'],
        ]);

        if($Fadly_request->hasFile('image')){
            $Fadly_image = $Fadly_request->file('image');
            $Fadly_imageName = time().'.'.$Fadly_image->getClientOriginalExtension();
            $Fadly_image->move(public_path('images'), $Fadly_imageName);
            $Fadly_buku->image = $Fadly_imageName;
            $Fadly_buku->save();
        }

        if (isset($Fadly_validate['kategori'])) {
            $Fadly_buku->kategori()->attach($Fadly_validate['kategori']);
        }

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('menambah buku', [
                'BukuID' => $Fadly_buku->BukuID,
                'Judul' => $Fadly_buku->Judul,
                'Penulis' => $Fadly_buku->Penulis,
                'Penerbit' => $Fadly_buku->Penerbit,
                'image' => $Fadly_buku->image,
                'TahunTerbit' => $Fadly_buku->TahunTerbit,
            ]);
        }

        return redirect()->route('buku.index');
    }

    public function create()
    {
        $Fadly_kategori = kategoriBuku::all();
        return view('buku.create', [
            'kategori' => $Fadly_kategori
        ]);
    }

    public function update(Request $Fadly_request, Buku $Fadly_buku)
    {
        $Fadly_validate = $Fadly_request->validate([
            'Judul' => 'required|string|max:255',
            'Penulis' => 'required|string|max:255',
            'Penerbit' => 'required|string|max:255',
            'TahunTerbit' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',

        ]);

        $Fadly_buku->update($Fadly_validate);

        if($Fadly_request->hasFile('image')){
            $Fadly_image = $Fadly_request->file('image');
            $Fadly_imageName = time().'.'.$Fadly_image->getClientOriginalExtension();
            $Fadly_image->move(public_path('images'), $Fadly_imageName);
            $Fadly_buku->image = $Fadly_imageName;
            $Fadly_buku->save();
        }

        $Fadly_buku->kategori()->sync($Fadly_request->kategori);

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('mengupdate buku', [
                'BukuID' => $Fadly_buku->BukuID,
                'Judul' => $Fadly_buku->Judul,
                'Penulis' => $Fadly_buku->Penulis,
                'Penerbit' => $Fadly_buku->Penerbit,
                'image' => $Fadly_buku->image,
                'TahunTerbit' => $Fadly_buku->TahunTerbit,
            ]);
        }

        return redirect()->route('buku.index');
    }

    public function edit(Buku $Fadly_buku)
    {
        $Fadly_kategori = kategoriBuku::all();

        return view('buku.edit', [
            'buku' => $Fadly_buku,
            'kategori' => $Fadly_kategori
        ]);
    }

    public function destroy(Buku $Fadly_buku)
    {
        $Fadly_buku->delete();

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('menghapus buku', [
                'BukuID' => $Fadly_buku->BukuID,
                'Judul' => $Fadly_buku->Judul,
                'Penulis' => $Fadly_buku->Penulis,
                'Penerbit' => $Fadly_buku->Penerbit,
                'image' => $Fadly_buku->image,
                'TahunTerbit' => $Fadly_buku->TahunTerbit,
            ]);
        }

        return redirect()->route('buku.index');
    }
}
