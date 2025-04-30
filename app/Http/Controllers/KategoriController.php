<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['result']=kategori::all();
        return view('kategori.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['result'] = null;
            return view('kategori/form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_kategori'=>'required|max:1000',
        ];
        $request->validate($rules);
        $data = [
            'nama_kategori'=> $request->nama_kategori
        ];

        $kategori= kategori::create($data);

        if($kategori) return redirect('/')->with('success','data berhasil ditambahkan');
        else return redirect('/')->with('error','data gagal ditambahkan');
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
        $data['result'] = \App\Models\kategori::where('id_kategori',$id)->first();
        return view ('kategori.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_kategori'=> 'required|max:100'
        ];

        $request->validate($rules);

        $input = $request->all();
        $result = \App\Models\kategori::where('id_kategori',$id)->first();
        $status = $result->update($input);

        if($status) return redirect('/')->with('success','data berhasil diubah');
        else return redirect('/')->with('error','data gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = \App\Models\kategori::where('id_kategori',$id)->first();
        $status = $result->delete();

        if($status) return redirect('/')->with('success','data berhasil dihapus');
        else return redirect('/')->with('error','data gagal dihapus');
    }
}
