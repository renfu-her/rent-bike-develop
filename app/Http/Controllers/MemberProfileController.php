<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberProfileController extends Controller
{
    public function show()
    {
        $member = Auth::guard('member')->user();
        return view('profile', compact('member'));
    }

    public function update(Request $request)
    {
        $member = Auth::guard('member')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:20|unique:members,id_number,' . $member->id,
            'address' => 'required|string|max:500',
        ]);

        $member->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'id_number' => $request->id_number,
            'address' => $request->address,
        ]);

        return redirect()->route('profile.show')->with('success', '個人資料更新成功！');
    }
}
