<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;

class ProfileController extends Controller
{
    protected $profileRepo;
    protected $brandRepo;

    public function __construct(
        UserRepositoryInterface $profileRepo,
        BrandRepositoryInterface $brandRepo
    ) {
        $this->profileRepo = $profileRepo;
        $this->brandRepo = $brandRepo;
    }

    public function show($id)
    {
        $brands = $this->brandRepo->getAll();
        $user = $this->profileRepo->find($id);

        return view('users.profile.show', compact('brands', 'user'));
    }

    public function edit($id)
    {
        $brands = $this->brandRepo->getAll();
        $user = $this->profileRepo->find($id);

        return view('users.profile.edit', compact('brands', 'user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = $this->profileRepo->find($id);

        if ($request->has('avatar')) {
            $img_path = public_path('images/profile/') . $user->avatar;
            if (File::exists($img_path)) {
                File::delete($img_path);
            }
            $file = $request->avatar;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile/'), $filename);
        }

        $this->profileRepo->update($id, [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'avatar' => $filename ?? Auth::user()->avatar, //neu ko update anh moi, update anh cu
        ]);
        
        return redirect()->route('user.profile', $id)->with('success', __('update success'));
    }
}
