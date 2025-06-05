<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['result'] = \App\Models\produk::all();  
    return view('produk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['result'] = null;
    return view('produk/form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_produk' => 'required|max:100',
            'sku'=>'required',
            'harga'=>'required',
            'stok'=>'required',
            'id_kategori'=>'required|exists:categories',
            'foto'=> 'required|mimes:jpeg,png|max:512'
        ];
        $request->validate($rules);

        $input = $request->only(['nama_produk', 'harga', 'stok', 'id_kategori','foto','sku']);
        if ($request->hasFile('foto')&& $request -> file('foto')->isValid()){
            $filename = uniqid(). "." . $request->file('foto')->getClientOriginalExtension();
            $request-> file('foto')->move(public_path('upload'),$filename);
            $input['foto']=$filename;
            $status = \App\Models\produk::create($input);
    
            if ($status) return redirect('produk')->with('success','data berhasil ditambahkan');
            else return redirect('produk')->with('error','data gagal ditambahkan');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['result'] = \App\Models\produk::where('id_produk',$id)->first();
        return view('produk/form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_produk' => 'required|string|max:255',
            'harga'=>'required|max:255',
            'stok'=>'required|max:100',
            'id_kategori'=>'required|exists:categories,id_kategori',
            'foto'=>'mimes:jpeg,png|max:512'
        ];
        $request->validate($rules);

        $input = $request->only(['nama_produk', 'harga', 'stok', 'id_kategori','foto']);
        if ($request->hasFile('foto')&& $request -> file('foto')->isValid()){
            $filename = uniqid(). "." . $request->file('foto')->getClientOriginalExtension();
            $request-> file('foto')->move(public_path('upload'),$filename);
            $input['foto']=$filename;     
        }
        $result = \App\Models\produk::where('id_produk',$id);
        $status = $result->update($input);

        if($status) return redirect('produk')->with('success','data berhasil diubah');
        else return redirect('produk')->with('error','data gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = \App\Models\produk::where('id_produk',$id)->first();
        $status = $result->delete();

        if($status) return redirect('produk')->with('success','data berhasil dihapus');
        else return redirect('produk')->with('error', 'data gagal dihapus');
    }

    public function barcode($id){
        $produk = produk::findOrFail($id);
        return view ('produk.print-barcode', compact('products'));
    }
}
