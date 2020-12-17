<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Setting;

class SettingController extends Controller
{
    use UploadImage;

    public function index()
    {
        $setting = Setting::first();
        return view('admin.pages.setting.index',compact('setting'));
    }

    public function update(SettingRequest $request,Setting $setting)
    {
        $setting->update($request->except('logo','icon'));
        if ($request->logo) {
            $this->upload($request->logo,$setting,'logo',true);
        }
        if ($request->icon) {
            $this->upload($request->icon,$setting,'icon',true);
        }
        return ['status' => 'success' ,'data' => 'تم التحديث بنجاح'];
    }
}
