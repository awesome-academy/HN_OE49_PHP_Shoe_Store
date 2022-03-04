<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function show($id)
    {
        $brands = Brand::all();
        $user = User::findOrFail($id);

        return view('users.profile.show', compact('brands', 'user'));
    }

    public function edit($id)
    {
        $brands = Brand::all();
        $user = User::findOrFail($id);

        return view('users.profile.edit', compact('brands', 'user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($request->hasFile('avatar')) {
            $img_path = public_path('images/profile/') . $user->avatar;
            if (File::exists($img_path)) {
                File::delete($img_path);
            }
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile/'), $filename);
        }

        $user->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'avatar' => $filename ?? Auth::user()->avatar, //neu ko update anh moi, update anh cu
        ]);

        return redirect()->route('user.profile', $id)->with('success', 'update success');
    }
}
