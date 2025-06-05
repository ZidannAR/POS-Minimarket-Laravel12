<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user['result'] = \App\Models\User::all();
        return view('user/index')->with($user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'username'  => 'required|max:100',
            'email'     => 'required|email|max:100',
            'password'  => 'required|max:100'
        ]);

        $input = $request->all();

        $status = \App\Models\User::create($input);

        if ($status) return redirect('/user')->with('success', 'Data berhasil di tambahkan');
        else return redirect('user')->with('error', 'Data gagal di tambahkan');
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
    public function edit(Request $request, string $id)
    {
       $user['result'] = \App\Models\User::where('id_user', $id)->first();
        return view('user/form')->with($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $request->validate([
            'username'  => 'required|max:100',
            'password'  => 'required|max:100'
        ]);

        $input = $request->all();

        $result = \App\Models\User::where('id_user', $id)->first();
        $status = $result->update($input);

        if ($status) return redirect('/user')->with('success', 'Data berhasil di ubah');
        else return redirect('user')->with('error', 'Data gagal di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = \App\Models\User::where('id_user', $id)->first();
        $status = $result->delete();

        if ($status) return redirect('/user')->with('success', 'Data berhasil di hapus');
        else return redirect('user')->with('error', 'Data gagal di hapus');
    }
}
