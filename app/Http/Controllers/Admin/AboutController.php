<?php

namespace App\Http\Controllers\Admin;

use App\About;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\AboutRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    use UploadImage;

    public function index()
    {
        $about = About::first();
        return view('admin.pages.about.form',compact('about'));
    }

    public function update(AboutRequest $request,About $about)
    {
        $about->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$about,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }
}
