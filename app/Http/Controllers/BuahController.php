<?php

namespace App\Http\Controllers;

use App\Models\Buah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('buah.index', ['buahs' => Buah::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'berat' => ['required', 'numeric',],
            'satuan_berat' => ['required', 'in:kg,gr'],
            'gambar' => 'required|file|image|max:5000'
        ]);

        $gambar = $request->file('gambar');
        $storage_res = Storage::disk('s3')->putFileAs('image', $gambar, $gambar->hashName(), [
            'ACL' => 'public-read-write',
        ]);
        $url_storage = Storage::disk('s3')->url($storage_res);

        $validateData['gambar'] = $url_storage;

        Buah::create($validateData);
        return to_route('buahs.index')->with('pesan', "Buah \"{$request->nama}\" berhasil ditambah");
    }

    /**
     * Display the specified resource.
     */
    public function show(Buah $buah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buah $buah)
    {
        return view('buah.edit', compact('buah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buah $buah)
    {
        $validateData = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'berat' => ['required', 'numeric',],
            'satuan_berat' => ['required', 'in:kg,gr'],
            'gambar' => 'file|image|max:5000'
        ]);

        if (isset($request->gambar)) {
            Storage::disk('s3')->delete(parse_url($buah->gambar));

            $gambar = $request->file('gambar');
            $storage_res = Storage::disk('s3')->putFileAs('image', $gambar, $gambar->hashName(), [
                'ACL' => 'public-read-write',
            ]);
            $url_storage = Storage::disk('s3')->url($storage_res);

            $validateData['gambar'] = $url_storage;
        }

        Buah::where('id', $buah->id)->update($validateData);

        return to_route('buahs.index')->with('pesan', "Buah \"{$request->nama}\" berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buah $buah)
    {
        Storage::disk('s3')->delete(parse_url($buah->gambar));
        $buah->delete();
        return to_route('buahs.index')->with('pesan', "Buah \"{$buah->nama}\" berhasil dihapus");
    }
}
