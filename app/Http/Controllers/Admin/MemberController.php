<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'dept_biro' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('members', 'public');
        }

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambah!');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'dept_biro' => 'required|string|max:255',
            'instagram' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only(['nama', 'jabatan', 'dept_biro', 'instagram']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada di storage
            if ($member->foto) {
                Storage::disk('public')->delete($member->foto);
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('members', 'public');
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->foto) {
            Storage::disk('public')->delete($member->foto);
        }
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}