<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use UploadImage;
    public function index()
    {
        $rows = Category::latest()->paginate(20);
        return view('admin.pages.category.index',compact('rows'));
    }

    public function create()
    {
        $category = new Category();
        return view('admin.pages.category.form',compact('category'));
    }

    public function store(CategoryRequest $request)
    {
        $category= Category::create($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$category);
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Category $category)
    {
        return view('admin.pages.category.form',compact('category'));
    }

    public function update(CategoryRequest $request,Category $category)
    {
        $category->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$category,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function destroy(Category $category)
    {
        $category->trash();
        return back();
    }
}
