<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $keranjang = session('keranjang', []);
        if(empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = $request->input('total');
        $uangDiberikan = preg_replace('/\D/', '', $request->input('uang_diberikan')); // hapus formatting rupiah jadi angka

        if($uangDiberikan < $total) {
            return redirect()->back()->with('error', 'Uang tidak cukup!');
        }

        DB::beginTransaction();

        try {
            // Simpan ke tabel orders
            $order = new Order();
            $order->invoice = 'INV-' . time();
            $order->total = $total;
            $order->save();

            // Simpan detail order
            foreach($keranjang as $id => $item) {
                $detail = new OrderDetail();
                $detail->order_id = $order->order_id;
                $detail->id_produk = $id;
                $detail->harga = $item['harga'];
                $detail->jumlah = $item['jumlah'];  // Pastikan ada kolom jumlah di orders_detail
                $detail->save();
            }

            DB::commit();

            // Kosongkan keranjang
            session()->forget('keranjang');

            return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
