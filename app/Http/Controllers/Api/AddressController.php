<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Resources\AddressResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class AddressController extends Controller
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
            $addresses = Address::with('products')->paginate(5);
        }else
        {
            $addresses = Address::with('products')->get();
        }
        return AddressResource::collection($addresses);
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
    public function singleAddress(Address $address)
    {
        return ProductResource::collection($address->products()->latest()->paginate(5));
    }
}
