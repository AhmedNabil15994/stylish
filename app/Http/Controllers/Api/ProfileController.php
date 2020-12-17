<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UploadImage;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UtilizeResource;
use App\Order;
use App\Product;
use App\Utilize;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use UploadImage;

    /**
     *
     * @SWG\Get(
     *      tags={"account"},
     *      path="/account/me",
     *      summary="Get the current logged in user",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function me()
    {
        return AccountResource::make(auth()->user());
    }

    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/update",
     *      summary="update My Account",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Parameter(
     *         name="f_name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoud",
     *      ),@SWG\Parameter(
     *         name="l_name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mohamed",
     *      ),@SWG\Parameter(
     *         name="phone",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="01208971865",
     *      ),@SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoudnada5050@gmail.com",
     *      ),
     *      @SWG\Parameter(
     *         name="photo",
     *         in="formData",
     *         type="file",
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param RegisterRequest $request
     * @return AccountResource
     */
    public function update(RegisterRequest $request)
    {
        $user = auth()->user();
        $user->update($request->except('photo'));
        if ($request->photo) {
            $this->upload($request->photo,$user,null,true);
        }
        return AccountResource::make(auth()->user());
    }


    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/update-password",
     *      summary="update My Password",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Parameter(
     *         name="current_password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="User Model"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param Request $request
     * @return AccountResource|\Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        if (Hash::check($request->current_password,$user->password))
        {
            if ($request->current_password === $request->password)
            {
                return response()->json(['status'=>200,'message'=>__('translate.same_password')]);
            }
            $user->update(['password'=>bcrypt($request->password)]);

            return AccountResource::make($user);
        }
        return response()->json(['status'=>400,'message'=>__('translate.wrong_password')]);
    }

    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/update-device-token",
     *      summary="update My device token",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="device_token",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="User Model"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param Request $request
     * @return AccountResource|\Illuminate\Http\JsonResponse
     */
    public function updateDeviceToken(Request $request)
    {
        $user = auth()->user();
        $user->update(['device_token'=>$request->device_token]);
        return AccountResource::make($user);
    }

    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/favorite/{product}",
     *      summary="Get single product",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *     @SWG\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Product $product
     * @return array
     */
    public function favorite(Product $product)
    {
        $user = auth()->user();
        if ($user->favorites()->where('product_id',$product->id)->first())
        {
            $user->favorites()->detach($product->id);
            return response()->json(['status'=>200,'message'=>__('translate.remove_successfully')]);
        }else
        {
            $user->favorites()->attach($product->id);
            return response()->json(['status'=>200,'message'=>__('translate.added_successfully')]);
        }
    }

    /**
     *
     * @SWG\Get(
     *      tags={"account"},
     *      path="/account/my-favorites",
     *      summary="Get my favorites Products",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Response(response=200, description="objects"),
     * )
     */
    public function myFavorites()
    {
        $user = auth()->user();
        return ProductResource::collection($user->favorites()->latest()->paginate(5));
    }

    /**
     *
     * @SWG\Get(
     *      tags={"account"},
     *      path="/account/my-orders",
     *      summary="Get my orders Product",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Response(response=200, description="objects"),
     * )
     */
    public function myOrders()
    {
        $user = auth()->user();
        return OrderResource::collection($user->orders()->latest()->paginate(5));
    }

    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/add-order/{product}",
     *      summary="send new order",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *     @SWG\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="size",
     *         description="
                [1=> صغير],
                [2=> متوسط],
                [3=> لارج],
                [4=> اكس لارج],
                [5=> 2 اكس لارج],
                [6=>3 اكس لارج]",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="color_code",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="color_name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="test_date",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="date",
     *      ),@SWG\Parameter(
     *         name="type",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param OrderRequest $request
     * @param Product $product
     * @return OrderResource
     */
    public function addOrder(OrderRequest $request,Product $product)
    {
        $user = auth()->user();
        $inputs = $request->all();
        $inputs['test_date'] = Carbon::parse($request->test_date);
        $inputs['product_id'] = $product->id;
        $order = $user->orders()->create($inputs);
        if ($request->type == 1)
        {
            $order->details()->create($request->all());
        }
        return OrderResource::make($order);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"account"},
     *      path="/account/my-orders/{order}",
     *      summary="Get single order",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *     @SWG\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Order $order
     * @return OrderResource
     */
    public function singleOrder(Order $order)
    {
        return OrderResource::make($order);
    }


    /**
     *
     * @SWG\Get(
     *      tags={"notifications"},
     *      path="/notifications",
     *      summary="Get all tips notifications paginate 5 per page",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Response(response=200, description="objects"),
     * )
     */
    public function tipsNotifications()
    {
        $tips = auth()->user()->notifications()->latest()->paginate(5);
        return NotificationResource::collection($tips);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"notifications"},
     *      path="/notifications/{id}",
     *      summary="read notification",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="objects"),
     * )
     */
    public function readNotification($id)
    {
         auth()->user()->notifications()->find($id)->markAsRead();
        return response()->json('read successfully',200);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"notifications"},
     *      path="/read-all-notifications",
     *      summary="read-all-notifications",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function readAllNotifications()
    {
        $tips = auth()->user()->unreadNotifications->markAsRead();
        return response()->json('read successfully',200);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"account"},
     *      path="/account/my-utilizes",
     *      summary="Get my Utilizes",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Response(response=200, description="objects"),
     * )
     */
    public function myUtilizes()
    {
        return UtilizeResource::collection(Utilize::where('user_id',auth()->user()->id)->latest()->paginate(5));
    }

    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/update-password-by-code",
     *      summary="update My Password by code",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Langouge Code",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="en",
     *      ),
     *      @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="User Model"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param Request $request
     * @return AccountResource|\Illuminate\Http\JsonResponse
     */
    public function updatePasswordByCode(Request $request)
    {
        $user = auth()->user();
        $user->update(['password'=>bcrypt($request->password)]);

        return AccountResource::make($user);
    }
}
