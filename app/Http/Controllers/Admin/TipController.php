<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\TipRequest;
use App\Notifications\TipNotification;
use App\Tip;
use App\User;
use App\Devices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class TipController extends Controller
{
    use UploadImage;
    public function index()
    {
        $rows = Tip::latest()->paginate(20);
        return view('admin.pages.tip.index',compact('rows'));
    }

    public function create()
    {
        $tip = new Tip();
        return view('admin.pages.tip.form',compact('tip'));
    }

    public function store(TipRequest $request)
    {
        $tip = Tip::create($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$tip);
        }
        return ['status' => 'success' ,'data' => 'تم اضافه العنصر بنجاح'];
    }

    public function edit(Tip  $tip)
    {
        return view('admin.pages.tip.form',compact('tip'));
    }

    public function update(TipRequest $request,Tip $tip)
    {
        $tip->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$tip,null,true);
        }
        return ['status' => 'success' ,'data' => 'تم تعديل العنصر بنجاح'];
    }


    public function destroy(Tip $tip)
    {
        $tip->trash();
        return back();
    }

    public function getLiveTip()
    {
        return view('admin.pages.tip.notification');
    }

    public function sendLiveTip(TipRequest $request)
    {   
        $tip = $request->except('_token','photo');
        if ($request->photo) {
            $destination = public_path('uploads');
            $photo = rand(000,999).str_replace(' ','-',$request->photo->getClientOriginalName());
            $request->photo->move($destination, $photo);
        }
        $tip['photo'] = asset('uploads/'.$photo);
        Notification::send(User::all(),new TipNotification($tip));
        Notification::send(Devices::all(),new TipNotification($tip));
        return ['status' => 'success' ,'data' => 'تم الارسال بنجاح'];
    }
}
