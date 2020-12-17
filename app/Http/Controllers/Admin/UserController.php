<?php

namespace App\Http\Controllers\Admin;

use App\Filters\UserFilter;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(UserFilter $filter)
    {
        $request = $filter->request;
        if ($request->ajax())
        {
            return  $this->changeStatus($request)->active;
        }
        $rows = User::latest()->filter($filter)->paginate(20);
        return view('admin.pages.user.index',compact('rows'));
    }

    public function changeStatus(Request $request)
    {
        $row = User::findOrfail($request->id);
        return $row->update(['status'=>$request->status]) ? $row : false;
    }

    public function destroy(User $user)
    {
        $user->trash();
        return back();
    }
}
