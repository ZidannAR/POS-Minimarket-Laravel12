<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $TotalProduk = \App\Models\produk::count();
        $TotalKategori = \App\Models\kategori::count();
        $TotalUser = \App\Models\User::count();


        $penjualanHariIni = Order::whereDate('created_at',today())->sum('total');
        $transaksiTerakhir = Order::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard.index',compact(
            'TotalProduk', 
        'TotalKategori', 
        'TotalUser',
        'penjualanHariIni', 
        'transaksiTerakhir'
        ));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
