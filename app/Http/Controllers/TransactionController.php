<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;

class TransactionController extends Controller
{
   public function checkout(Request $request)
{
    $keranjang = session('keranjang', []);
    if (empty($keranjang)) {
        return redirect()->back()->with('error', 'Keranjang kosong!');
    }

    $totalAwal = $request->input('total_awal');
    $diskon = 0;
    $idCustomer = null;

    // Validasi member jika diisi
    if ($request->filled('no_member')) {
        $member = Customer::where('no_hp', $request->no_member)
                          ->where('status_member', true)
                          ->first();

        if ($member) {
            $diskon = $totalAwal * 0.05;
            $idCustomer = $member->id_customers;
        }
    }

    $totalAkhir = $totalAwal - $diskon;
    $uangDiberikan = preg_replace('/\D/', '', $request->input('uang_diberikan'));

    // Validasi uang
    if ($uangDiberikan < $totalAkhir) {
        return back()->with('error', 'Uang tidak cukup!');
    }

    DB::beginTransaction();

    try {
        // Simpan ke tabel orders
        $order = new Order();
        $order->invoice = 'INV-' . time();
        $order->total = $totalAkhir;
        $order->diskon = $diskon;
        $order->id_customers = $idCustomer;
        $order->status_member = $idCustomer ? true : false;
        $order->save();

        foreach ($keranjang as $id => $item) {
            $detail = new OrderDetail();
            $detail->order_id = $order->order_id;
            $detail->id_produk = $id;
            $detail->harga = $item['harga'];
            $detail->jumlah = $item['jumlah'];
            $detail->save();

            // Update stok produk
            $produk = \App\Models\Produk::find($id);
            if ($produk) {
                $produk->stok -= $item['jumlah'];
                $produk->save();
            }
        }

        DB::commit();
        session()->forget('keranjang');

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}
