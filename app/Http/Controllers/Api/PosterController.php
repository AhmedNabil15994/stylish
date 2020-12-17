<?php

namespace App\Http\Controllers\Api;

use App\Poster;
use App\Http\Resources\PosterResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class PosterController extends Controller
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
        if ($request->paginate)
        {
            $posters = Poster::orderBy('id','DESC')->paginate(5);
        }else
        {
            $posters = Poster::orderBy('id','DESC')->get();
        }
        return PosterResource::collection($posters);
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
    public function singlePoster(Poster $poster)
    {
        return PosterResource::make($poster);
    }
}
