<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\SliderRequest;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    use UploadImage;
    public function index()
    {
        $rows = Slider::latest()->paginate(20);
        return view('admin.pages.slider.index',compact('rows'));
    }

    public function create()
    {
        $slider = new Slider();
        return view('admin.pages.slider.form',compact('slider'));
    }

    public function store(SliderRequest $request)
    {
        $slider = Slider::create($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$slider);
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Slider $slider)
    {
        return view('admin.pages.slider.form',compact('slider'));
    }

    public function update(SliderRequest $request,Slider $slider)
    {
        $slider->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$slider,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function destroy(Slider $slider)
    {
        $slider->trash();
        return back();
    }
}
