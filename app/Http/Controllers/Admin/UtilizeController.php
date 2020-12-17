<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Filters\UtilizeFilter;
use App\Notifications\StatusNotification;
use App\Notifications\TipNotification;
use App\Utilize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class UtilizeController extends Controller
{
    public function index(UtilizeFilter $filter)
    {
        $request = $filter->request;
//        dd($request->all());
        if ($request->hasAny(['status','id']))
        {
            $utilize = Utilize::findOrfail($request->id);
            $utilize->update(['active'=>$request->status]);

            $data=[
                'utilize_id'=>$utilize->id,
                'user_id'=>$utilize->user_id,
                'en'=>[
                    'title'=>"Your Utilize ({$utilize->name}) Status Change To ". $utilize->active ? 'Active' : 'DisActive',
                ],
                'ar'=>[
                    'title'=>"تم تغيير حالة المنتج ({$utilize->name}) ل ". $utilize->active_name
                ]
            ];
            Notification::send($utilize->user,new StatusNotification($data));
            return ['status'=>'success'];
        }
        $rows = Utilize::latest()->filter($filter)->paginate(15);
        $main_categories = Category::all();
        return view('admin.pages.utilize.index',compact('rows','main_categories'));
    }


    public function destroy(Utilize $utilize)
    {
        $utilize->trash();
        return back();
    }
}
