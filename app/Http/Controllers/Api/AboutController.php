<?php

namespace App\Http\Controllers\Api;

use App\About;
use App\Http\Resources\AboutResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"about"},
     *      path="/about-us",
     *      summary="Get about-us data",
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
        $about = About::first();
        return AboutResource::make($about);
    }
}
