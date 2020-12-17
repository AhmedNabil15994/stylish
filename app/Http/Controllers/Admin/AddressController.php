<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Http\Requests\Admin\AddressRequest;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index()
    {
        $rows = Address::latest()->paginate(20);
        return view('admin.pages.address.index',compact('rows'));
    }

    public function create()
    {
        $address = new Address();
        return view('admin.pages.address.form',compact('address'));
    }

    public function store(AddressRequest $request)
    {
        Address::create($request->all());
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Address $address)
    {
        return view('admin.pages.address.form',compact('address'));
    }

    public function update(AddressRequest $request,Address $address)
    {
        $address->update($request->all());
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function destroy(Address $address)
    {
        $address->trash();
        return back();
    }
}
