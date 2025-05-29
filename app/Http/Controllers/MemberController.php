<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index()
    {
        $members = Customer::all(); // Ubah variabel ke plural
        return view('member.index', compact('members')); // Sesuaikan
    }

    public function create()
    {
        return view('member.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric|unique:customers',
            'status_member' => 'boolean'
        ]);

        // Handle checkbox jika tidak dicentang
        $data = $request->all();
        if(!isset($data['status_member'])) {
            $data['status_member'] = false;
        }

        Customer::create(array_merge($data, [
            'tanggal_daftar' => now(),
        ]));

        return redirect()->route('member.index')->with('success', 'Member berhasil didaftarkan');
    }

    public function show(string $id)
    {
        // Opsional: Implementasi jika diperlukan
    }

    public function edit(string $id)
    {
        $member = Customer::findOrFail($id);
        return view('member.form', compact('member'));
    }

    public function update(Request $request, string $id) // Ubah parameter
    {
        $member = Customer::findOrFail($id); // Ambil model secara manual
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp'     => [
            'required',
            'numeric',
            Rule::unique('customers', 'no_hp')
                ->ignore($member->id_customers, 'id_customers'),
        ], 
            'status_member' => 'boolean'
        ]);

        // Handle checkbox jika tidak dicentang
        $data = $request->all();
        if(!isset($data['status_member'])) {
            $data['status_member'] = false;
        }

        $member->update($data);
        
        return redirect()->route('member.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id) // Ubah parameter
    {
        $member = Customer::findOrFail($id); // Ambil model secara manual
        $member->delete();
        
        return redirect()->route('member.index')->with('success', 'Data berhasil dihapus');
    }
}