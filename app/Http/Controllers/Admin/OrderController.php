<?php

namespace App\Http\Controllers\Admin;

use App\Filters\OrderFilter;
use App\Notifications\StatusNotification;
use App\Notifications\TipNotification;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function index(OrderFilter $filter)
    {
        $request = $filter->request;
        if ($request->hasAny(['status','id']))
        {
            $order =  Order::findOrfail($request->id);
            $order->update(['status'=>$request->status]);
            switch ($order->status) {
                case -1:
                    $order_status = ['Cancel','الغاء'];
                    break;
                case 0:
                    $order_status = ['Pending','انتظار'];
                    break;
                case 1:
                    $order_status = ['Prepare','تحضير'];
                    break;
                case 2:
                    $order_status = ['Delivery','تسليم'];
                    break;
                default:
                    $order_status = '';
            }
            $tip=[
                'order_id'=>$order->id,
                'user_id'=>$order->user_id,
                'en'=>[
                    'title'=>'Your Order Status Change To '. $order_status[0]
                ],
                'ar'=>[
                    'title'=>'تم تغيير حالة الطلب ل '. $order_status[1]
                ]
            ];
            Notification::send($order->user,new StatusNotification($tip));
            return ['status'=>'success'];
        }
        $rows = Order::with('product','details')->filter($filter)->latest()->paginate(20);
        return view('admin.pages.order.index',compact('rows'));
    }


    public function destroy(Order $order)
    {
        $order->trash();
        return back();
    }
}
