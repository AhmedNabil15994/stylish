<?php

namespace App\Http\Controllers\Api;

use App\Filters\UtilizeFilter;
use App\Helpers\UploadImage;
use App\Http\Requests\Api\UtilizeRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilizeResource;
use App\User;
use App\Utilize;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class UtilizeController extends Controller
{
    use UploadImage;

    /**
     *
     * @SWG\Get(
     *      tags={"utilizes"},
     *      path="/utilizes",
     *      summary="Get all utilizes with paginated 5 per page",
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
    public function index()
    {
        return UtilizeResource::collection(Utilize::activeUtilizes()->latest()->paginate(5));
    }

    /**
     *
     * @SWG\post(
     *      tags={"utilizes"},
     *      path="/utilizes/add",
     *      summary="add new utilize",
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
     *         name="name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="price",
     *         in="formData",
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
     *         name="status",
     *         description="
    [1=> سبئ],
    [2=> جيد],
    [3=>ممتاز]",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="phone",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="address",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="lat",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="lng",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="category_id",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="notes",
     *         in="formData",
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="main_photo",
     *         in="formData",
     *         required=true,
     *         type="file",
     *      ),@SWG\Parameter(
     *         name="sub_photos[]",
     *         description="Array of Files",
     *         in="formData",
     *         type="array",
     *          @SWG\Items(
     *          type="string",
     *          )
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param UtilizeRequest $request
     * @return
     */
    public function store(UtilizeRequest $request)
    {
        $user = auth()->user();
        $utilize = $user->utilizes()->create($request->except('main_photo','sub_photos'));
        if ($request->main_photo) {
            $this->upload($request->main_photo,$utilize,'main');
        }
        try{
            if (count($request->sub_photos)) {
                foreach ($request->sub_photos as $photo)
                {
                    $this->upload($photo,$utilize,'sub');
                }
            }
        }catch (\Exception $exception)
        {

        }
        return UtilizeResource::make($utilize);
    }

    /**
     *
     * @SWG\post(
     *      tags={"utilizes"},
     *      path="/utilizes/update/{utilize}",
     *      summary="add new utilize",
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
     *         name="utilize",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Parameter(
     *         name="name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="price",
     *         in="formData",
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
     *         name="status",
     *         description="
    [1=> سبئ],
    [2=> جيد],
    [3=>ممتاز]",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="phone",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="address",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="lat",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="lng",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="category_id",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="notes",
     *         in="formData",
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="main_photo",
     *         in="formData",
     *         type="file",
     *      ),@SWG\Parameter(
     *         name="sub_photos[]",
     *         description="Array of Files",
     *         in="formData",
     *         type="array",
     *          @SWG\Items(
     *          type="string",
     *          )
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param UtilizeRequest $request
     * @param Utilize $utilize
     * @return UtilizeResource
     */
    public function update(UtilizeRequest $request,Utilize $utilize)
    {
        $user = auth()->user();
        if ($utilize->user_id != $user->id)
        {
            return response()->json(['unauthorized'],401);
        }
        $updated =$utilize->update($request->except('main_photo','sub_photos'));
        if ($request->main_photo) {
            $this->upload($request->main_photo,$utilize,'main',true);
        }
        try
        {
            if (count($request->sub_photos)) {
                foreach ($request->sub_photos as $photo)
                {
                    $this->upload($photo,$utilize,'sub',true);
                }
            }
        }catch (\Exception $exception)
        {

        }
        return UtilizeResource::make($utilize);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"utilizes"},
     *      path="/utilize-search",
     *      summary="Search in utilizes",
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
     *         name="category_id",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="color_code",
     *         in="query",
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="address_id",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="size",
     *      description="
    [1=> صغير],
    [2=> متوسط],
    [3=> لارج],
    [4=> اكس لارج],
    [5=> 2 اكس لارج],
    [6=>3 اكس لارج]",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="price_from",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="price_to",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="status",
     *         description="
    [1=> سبئ],
    [2=> جيد],
    [3=>ممتاز]",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="lat",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),@SWG\Parameter(
     *         name="lng",
     *         in="query",
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param UtilizeFilter $filter
     * @return AnonymousResourceCollectionAlias
     */
    public function utilizesSearch(UtilizeFilter $filter)
    {
        $products = Utilize::activeUtilizes()->filter($filter)->latest()->paginate(5);
        return  UtilizeResource::collection($products);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"utilizes"},
     *      path="/utilizes/{utilize}",
     *      summary="Get single utilize",
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
     *         name="utilize",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Utilize $utilize
     * @return UtilizeResource
     */
    public function singleUtilize(Utilize $utilize)
    {
        return UtilizeResource::make($utilize);
    }

    /**
     *
     * @SWG\Delete(
     *      tags={"utilizes"},
     *      path="/utilizes/delete/{utilize}",
     *      summary="delete utilize",
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
     *         name="utilize",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="text"),
     * )
     * @param Utilize $utilize
     * @return UtilizeResource
     */
    public function destroy(Utilize $utilize)
    {   
        if (auth()->id() != $utilize->user_id)
        {
            return response()->json([
                'message' => 'unauthorized',
                ],401);
        }
        $utilize->delete();
        return response()->json([
            'message' => 'success',
        ],200);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"utilizes"},
     *      path="/user/{user}/utilizes",
     *      summary="get all user utilizes paginated",
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
     *         name="user",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="text"),
     * )
     */
    public function userUtilizes(User $user)
    {
        $utilizes = Utilize::where('user_id',$user->id)->where('active',1)->latest()->paginate(5);
        return UtilizeResource::collection($utilizes);
    }
}
