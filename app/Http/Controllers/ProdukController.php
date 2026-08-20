<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;

        $produk = Produk::when($cari, function ($query, $cari) {
            $query->where('kode_produk', 'like', "%{$cari}%")
                ->orWhere('nama_produk', 'like', "%{$cari}%")
                ->orWhere('kategori_produk', 'like', "%{$cari}%");
        })
        ->orderBy('id_produk', 'desc')
        ->paginate(10)
        ->withQueryString();

        return view('produk.index', compact('produk', 'cari'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_produk' => 'required|max:30|unique:produk,kode_produk',
            'nama_produk' => 'required|max:100',
            'kategori_produk' => 'required|max:100',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'satuan_produk' => 'required|max:50',
        ]);

        $data['status_produk'] = 'aktif';

        Produk::create($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'kode_produk' => [
                'required',
                'max:30',
                Rule::unique('produk', 'kode_produk')
                    ->ignore($produk->id_produk, 'id_produk'),
            ],
            'nama_produk' => 'required|max:100',
            'kategori_produk' => 'required|max:100',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'satuan_produk' => 'required|max:50',
        ]);

        $produk->update($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diubah.');
    }

    public function nonaktifkan(Produk $produk)
    {
        $produk->update([
            'status_produk' => 'nonaktif'
        ]);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dinonaktifkan.');
    }
}