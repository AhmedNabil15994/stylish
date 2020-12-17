<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TipResource;
use App\Product;
use App\Setting;
use App\Slider;
use App\Tip;
use App\Devices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"home"},
     *      path="/sliders",
     *      summary="Get All Slider With pagination 5 per Page",
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
    public function sliders()
    {
        return SliderResource::collection(Slider::latest()->paginate(5));
    }

    public function insertToken(Request $request){
        $device_token = $request->input('device_token');
        if($device_token){
            $deviceObj = Devices::where('device_token',$device_token)->first();
            if($deviceObj == null){
                $deviceObj = new Devices;
                $deviceObj->device_token = $device_token;
                $deviceObj->save();
            }
        }
        return $deviceObj->id;
    }

    /**
     *
     * @SWG\Get(
     *      tags={"home"},
     *      path="/last-products",
     *      summary="Get Last Products",
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
    public function lastProducts()
    {
        $products = Product::activeProducts()->with('category')->where('in_home',1)->latest()->get();
        return ProductResource::collection($products);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"tips"},
     *      path="/tips",
     *      summary="Get all tips paginate 5 per page",
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
    public function tips()
    {
        return TipResource::collection(Tip::latest()->paginate(5));
    }

    /**
     *
     * @SWG\Get(
     *      tags={"setting"},
     *      path="/setting",
     *      summary="Get settings of site",
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
    public function setting()
    {
        return SettingResource::make(Setting::first());
    }
}
