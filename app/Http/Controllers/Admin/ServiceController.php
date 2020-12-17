<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\ServiceRequest;
use App\Service;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    use UploadImage;
    public function index()
    {
        $rows = Service::latest()->paginate(20);
        return view('admin.pages.service.index',compact('rows'));
    }

    public function create()
    {
        $service = new Service();
        return view('admin.pages.service.form',compact('service'));
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$service);
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Service $service)
    {
        return view('admin.pages.service.form',compact('service'));
    }

    public function update(ServiceRequest $request,Service $service)
    {
        $service->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$service,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function users(Request $request){
        if ($request->ajax()){
            return  $this->changeStatus($request)->active;
        }
        $rows = User::with('works','user_service.service');
        
        if(isset($request->phone) && !empty(isset($request->phone))){
            $rows->whereHas('user_service',function($whereHasQuery) use ($request){
                $whereHasQuery->where('phone',$request->phone);
            });
        }

        $rows= $rows->where('is_service','!=',null)->where(function($whereQuery) use ($request){
            if(isset($request->service_admin_active)){
                if($request->service_admin_active == 0){
                    $whereQuery->where('service_admin_active',$request->service_admin_active)->orWhere('service_admin_active',null);
                }elseif($request->service_admin_active == 1){
                    $whereQuery->where('service_admin_active',$request->service_admin_active);
                }
            }
        })->orderBy('id','DESC')->paginate(20);

        return view('admin.pages.service.users',compact('rows'));
    }


    public function changeStatus(Request $request)
    {
        $row = User::findOrfail($request->id);
        return $row->update(['service_admin_active'=>$request->service_admin_active]) ? $row : false;
    }

    public function destroy(Service $service)
    {   
        $service->trash();
        return back();
    }
}
