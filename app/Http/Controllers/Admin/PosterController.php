<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\PosterRequest;
use App\Poster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosterController extends Controller
{
    use UploadImage;
    public function index()
    {
        $rows = Poster::latest()->paginate(20);
        return view('admin.pages.poster.index',compact('rows'));
    }

    public function create()
    {
        $poster = new Poster();
        return view('admin.pages.poster.form',compact('poster'));
    }

    public function store(PosterRequest $request)
    {
        $poster = Poster::create($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$poster);
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Poster $poster)
    {
        return view('admin.pages.poster.form',compact('poster'));
    }

    public function update(PosterRequest $request,Poster $poster)
    {
        $poster->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$poster,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function destroy(Poster $poster)
    {
        $poster->trash();
        return back();
    }
}
