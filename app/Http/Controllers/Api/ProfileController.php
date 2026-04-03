<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member; // Import model Member
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getMembers()
    {
        // Ambil semua data anggota dari database
        $members = Member::all();

        return response()->json([
            'status' => 'success',
            'data' => $members
        ]);
    }
}