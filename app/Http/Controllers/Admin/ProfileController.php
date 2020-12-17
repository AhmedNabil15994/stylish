<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    use UploadImage;

    public function index()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.profile.index',compact('user'));
    }

    public function update(ProfileRequest $request,Admin $user)
    {
        $user->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$user,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }
}
