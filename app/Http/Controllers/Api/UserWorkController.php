<?php

namespace App\Http\Controllers\Api;

use App\UserWork;
use App\Http\Resources\UserWorkResource;
use App\Http\Requests\Api\UserWorkRequest;
use Illuminate\Http\Request;
use App\Helpers\UploadImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class UserWorkController extends Controller
{

    use UploadImage;
    /**
     *
     * @SWG\Get(
     *      tags={"store"},
     *      path="/categories",
     *      summary="Get All categories without Pagination and for Pagination send parametr paginate = 1",
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
        if ($request->paginate)
        {
            $categories = UserWork::latest()->where(function($whereQuery) use ($request){
                if(isset($request->user_id) && !empty($request->user_id)){
                    $whereQuery->where('user_id',$request->user_id);
                }
            })->paginate(5);
        }else
        {
            $categories = UserWork::latest()->where(function($whereQuery) use ($request){
                if(isset($request->user_id) && !empty($request->user_id)){
                    $whereQuery->where('user_id',$request->user_id);
                }
            })->get();
        }
        return UserWorkResource::collection($categories);
    }

  
    public function store(UserWorkRequest $request)
    {
        $user = auth()->user();
        $input = $request->except('photo');
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['user_id'] = auth()->user()->id;
        $work = UserWork::create($input);
        if ($request->photo) {
            $this->upload($request->photo,$work,null,true);
        }
        return UserWorkResource::make($work);
    }

    public function update(UserWorkRequest $request,UserWork $work)
    {
        $input = $request->except('photo');
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['user_id'] = auth()->user()->id;
        $user = auth()->user();
        if ($work->user_id != $user->id){
            return response()->json(['unauthorized'],401);
        }
        $updated =$work->update($input);
        if ($request->photo) {
            $this->upload($request->photo,$work,null,true);
        }
        return UserWorkResource::make($work);
    }

    public function destroy(UserWork $work)
    {   
        if (auth()->id() != $work->user_id)
        {
            return response()->json([
                'message' => 'unauthorized',
                ],401);
        }
        $work->delete();
        return response()->json([
            'message' => 'success',
        ],200);
    }
}
