<?php

namespace App\Http\Controllers;

use App\Models\kategoriBuku;
use App\Traits\UserTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    use UserTrait;

    public function index()
    {
        return view('kategori.index', [
            'kategori' => kategoriBuku::all()
        ]);
    }

    public function store(Request $Fadly_request)
    {
        $Fadly_validate = $Fadly_request->validate([
            'NamaKategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategoribuku', 'NamaKategori'),
            ],
            'deskripsi' => 'nullable|string|min:3'
        ]);

        $Fadly_kategori = KategoriBuku::create([
            'NamaKategori' => $Fadly_validate['NamaKategori'],
            'deskripsi' => $Fadly_validate['deskripsi']
        ]);

        if(!Auth::user()->isAdmin()){
            $this->logActivity('menambah kategori', [
                'KategoriID' => $Fadly_kategori->KategoriID,
                'NamaKategori' => $Fadly_kategori->NamaKategori,
                'deskripsi' => $Fadly_kategori->deskripsi
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function update(Request $Fadly_request, KategoriBuku $Fadly_kategori)
    {
        $Fadly_request->validate([
            'NamaKategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategoribuku', 'NamaKategori')->ignore($Fadly_kategori->KategoriID, 'KategoriID'),
            ],
            'deskripsi' => 'nullable|string|min:3'
        ]);

        $Fadly_kategori->update($Fadly_request->only(['NamaKategori', 'deskripsi']));

        if(!Auth::user()->isAdmin()){
            $this->logActivity('mengupdate kategori', [
                'KategoriID' => $Fadly_kategori->KategoriID,
                'NamaKategori' => $Fadly_kategori->NamaKategori,
                'deskripsi' => $Fadly_kategori->deskripsi
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function edit(KategoriBuku $Fadly_kategori)
    {
        return view('kategori.edit', [
            'kategori' => $Fadly_kategori
        ]);
    }

    public function destroy(kategoriBuku $Fadly_kategori)
    {
        $Fadly_kategori->delete();

        if(!Auth::user()->isAdmin()){
            $this->logActivity('menghapus kategori', [
                'KategoriID' => $Fadly_kategori->KategoriID,
                'NamaKategori' => $Fadly_kategori->NamaKategori,
                'deskripsi' => $Fadly_kategori->deskripsi
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
