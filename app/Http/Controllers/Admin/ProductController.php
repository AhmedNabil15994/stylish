<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Category;
use App\Filters\ProductFilter;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\ProductRequest;
use App\Image;
use App\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use UploadImage;
    public function index(ProductFilter $filter)
    {
        $rows = Product::filter($filter)->latest()->paginate(20);
//        $rows = Product::latest()->paginate(20);
        $main_categories = Category::all();
        return view('admin.pages.product.index',compact('rows','main_categories'));
    }

    public function create()
    {
        $product = new Product();
        $main_categories = Category::all();
        $addresses  = Address::all();
        return view('admin.pages.product.form',compact('product','main_categories','addresses'));
    }

    public function store(ProductRequest $request)
    {
        $inputs = $request->except('main','photo');
        $product= Product::create($inputs);
        if ($request->main) {
            $this->upload($request->main,$product,'main');
        }
        if (count($request->photo)) {
            foreach ($request->photo as $photo)
            {
                $this->upload($photo,$product,'sub');
            }
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Product $product)
    {
        $main_categories = Category::all();
        $addresses  = Address::all();
        return view('admin.pages.product.form',compact('product','main_categories','addresses'));
    }

    public function update(ProductRequest $request,Product $product)
    {
        $inputs = $request->except('main','photo');
        $product->update($inputs);
        if ($request->main) {
            $this->upload($request->main,$product,'main',true);
        }
        if (count($request->photo) and !empty($request->photo[0])) {
            foreach ($request->photo as $photo)
            {
                $this->upload($photo,$product,'sub',true);
            }
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function destroy(Product $product)
    {
        $product->trash();
        return back();
    }

    public function deleteImage(Image $image)
    {
        if (is_file($image->full_url))
        {
            @unlink($image->full_url);
        }
        if ($image->delete())
            return ['status' =>'success','data'=>'تم حذف الصورة بنجاح'];
        return ['status' =>'error','data'=>'حدث خطأ حاول مره اخرى'];
    }
}
