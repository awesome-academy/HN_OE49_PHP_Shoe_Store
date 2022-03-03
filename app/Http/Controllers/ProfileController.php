<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id)
    {
        $brands = Brand::all();
        $user = User::find($id);

        return view('users.profile.show', compact('brands', 'user'));
    }

    public function edit($id)
    {
        $brands = Brand::all();
        $user = User::find($id);

        return view('users.profile.edit', compact('brands', 'user'));
    }

    public function update(Request $request, $id)
    {
        //
    }
}
