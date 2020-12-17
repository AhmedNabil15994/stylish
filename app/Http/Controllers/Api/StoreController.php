<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Filters\ProductFilter;
use App\Filters\UtilizeFilter;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UtilizeResource;
use App\Product;
use App\Utilize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class StoreController extends Controller
{

    public function getProductsByIds(Request $request){
        $ids = $request->ids;
        $idsArray = explode(',', $ids);
        $products = Product::whereIn('id',$idsArray)->get();
        return ProductResource::collection($products);
    }

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
            $categories = Category::with('products')->paginate(5);
        }else
        {
            $categories = Category::with('products')->get();
        }
        return CategoryResource::collection($categories);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"store"},
     *      path="/categories/{category}",
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
     *         name="category",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Category $category
     * @return CategoryResource
     */
    public function singleCategory(Category $category)
    {
        return ProductResource::collection($category->products()->latest()->paginate(5));
    }

    /**
     *
     * @SWG\Get(
     *      tags={"store"},
     *      path="/products",
     *      summary="Get All products With pagination 5 per Page",
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
    public function allProducts()
    {
        return ProductResource::collection(Product::activeProducts()->with('category')->latest()->paginate(5));
    }

    /**
     *
     * @SWG\Get(
     *      tags={"store"},
     *      path="/products/{product}",
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
    public function singleProduct(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"store"},
     *      path="/product-search",
     *      summary="Search in products",
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
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param ProductFilter $filter
     * @return AnonymousResourceCollectionAlias
     */
    public function productsSearch(ProductFilter $filter)
    {
        $products = Product::activeProducts()->filter($filter)->latest()->paginate(5);
        return  ProductResource::collection($products);
    }
}
