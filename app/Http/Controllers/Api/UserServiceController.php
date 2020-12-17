<?php

namespace App\Http\Controllers\Api;

use App\UserService;
use App\Service;
use App\Http\Resources\UserServiceResource;
use App\Http\Requests\Api\UserServiceRequest;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class UserServiceController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"addresses"},
     *      path="/addresses",
     *      summary="Get All addresses without Pagination and for Pagination send parametr paginate = 1",
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
     *         name="paginate",
     *         in="query",
     *         description="get all data without Pagination make it = 0 and  for paginated data make it = 1",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Request $request
     * @return AnonymousResourceCollectionAlias
     */
    public function index(Request $request)
    {
        $posters = UserService::where('user_id',auth()->user()->id)->get();
        return UserServiceResource::collection($posters);
    }

    public function availableServices(Request $request)
    {
        if ($request->paginate)
        {
            $posters = Service::orderBy('id','DESC')->paginate(5);
        }else
        {
            $posters = Service::orderBy('id','DESC')->get();
        }
        return ServiceResource::collection($posters);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"addresses"},
     *      path="/addresses/{address}",
     *      summary="Get single Category",
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
     *         name="address",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Address $address
     * @return AnonymousResourceCollectionAlias
     */
    public function update(UserServiceRequest $request)
    {   
        $userService = UserService::where('user_id',auth()->user()->id)->first();
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        if($userService){
            $input['updated_at'] = date('Y-m-d H:i:s');
            $userService->update($input);
        }else{
            $input['created_at'] = date('Y-m-d H:i:s');
            UserService::insert($input);
        }
        return response()->json([
            'message' => 'update success',
        ],200);
    }
}
