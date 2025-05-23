<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $data['result'] = \App\Models\produk::all();
        return view('kasir.index', $data);
    }

    public function store(Request $request)
    {
        $id = $request->id_produk;
        $produk = Produk::findOrFail($id);

        $keranjang = session('keranjang', []);
        $jumlah_dalam_keranjang = isset($keranjang[$id]) ? $keranjang[$id]['jumlah'] : 0;

        if ($produk->stok - $jumlah_dalam_keranjang <= 0) {
            return redirect()->back()->with('error', 'Produk sudah habis!');
        }

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
        } else {
            $keranjang[$id] = [
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'stok' => $produk->stok,
                'jumlah' => 1
            ];
        }

        session(['keranjang' => $keranjang]);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function tambah($id)
    {
        $keranjang = session('keranjang', []);
        $produk = Produk::findOrFail($id);

        // Cek apakah stok masih tersedia
        $stok_sisa = $produk->stok - ($keranjang[$id]['jumlah'] ?? 0);

        if ($stok_sisa <= 0) {
            // Request dari JavaScript (AJAX)
            if (request()->ajax()) {
                return response()->json(['status' => 'sold_out']);
            }
            return redirect()->back()->with('error', 'Produk sudah habis!');
        }

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
        } else {
            $keranjang[$id] = [
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'stok' => $produk->stok,
                'jumlah' => 1
            ];
        }

        session(['keranjang' => $keranjang]);

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'jumlah' => $keranjang[$id]['jumlah'], 'stok_tersisa' => $produk->stok - $keranjang[$id]['jumlah']]);
        }

        return redirect()->back();
    }

    public function destroy()
    {
        session()->forget('keranjang');
        return redirect()->back();
    }

    public function scanBarcode(Request $request)
    {
        $barcode = $request->input('sku');
    
        if (!$barcode) {
            return response()->json([
                'success' => false,
                'message' => 'Barcode tidak ditemukan dalam permintaan'
            ]);
        }
    
        $product = Produk::where('sku', $barcode)->first();
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }
    
        if ($product->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok habis'
            ]);
        }
    
        $keranjang = session()->get('keranjang', []);
    
        if (isset($keranjang[$product->id_produk])) {
            $keranjang[$product->id_produk]['jumlah'] += 1;
        } else {
            $keranjang[$product->id_produk] = [
                'nama_produk' => $product->nama_produk,
                'harga' => $product->harga,
                'stok' => $product->stok,
                'jumlah' => 1
            ];
        }
    
        session(['keranjang' => $keranjang]);
    
        return back(); 
    }
}
