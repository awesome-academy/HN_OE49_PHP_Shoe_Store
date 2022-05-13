<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepo;
    protected $brandRepo;
    protected $imageRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo,
        ImageRepositoryInterface $imageRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->imageRepo = $imageRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = $this->brandRepo->getAll();
        $products = $this->productRepo->searchProduct($request->name, $request->brand_id);
        $products = $products->paginate(config('paginate.pagination'));

        return response()->json([
            'brands' => $brands,
            'products' => ProductResource::collection($products),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $product = $this->productRepo->create($request->except('images'));
        $data = [];
        if ($files = $request->file('images')) {
            foreach ($files as $key => $file) {
                $new_name = time() .'-' . $file->getClientOriginalName();
                $file->move(public_path('images/products/'), $new_name);
                $data[$key] = [
                    'product_id' => $product->id,
                    'name' => $new_name,
                ];
            }
            $images = $this->imageRepo->insert($data);
        }
        
        return response()->json([
            'message' => __('create success'),
            'product' => new ProductResource($product),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepo->find($id);
        $images = $this->imageRepo->getImage($product->id);

        return response()->json([
            'product' => new ProductResource($product),
            'images' => $images,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $product = $this->productRepo->update($id, $request->except('images'));
        if ($request->has('images')) {
            $data = [];
            if ($files = $request->file('images')) {
                foreach ($files as $key => $file) {
                    $new_name = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('images/products/'), $new_name);
                    $data[$key] = [
                        'product_id' => $id,
                        'name' => $new_name,
                    ];
                }
                $this->imageRepo->insert($data);
            }
        }

        return response()->json([
            'message' => __('update success'),
            'product' => new ProductResource($product),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images = $this->imageRepo->getImage($id);
        foreach ($images as $image) {
            $file_name = public_path('images/products/') . $image->name;
            $this->imageRepo->deleteFileImage($file_name);
        }
        $this->productRepo->delete($id);

        return response()->json([
            'message' => __('delete success'),
        ], 200);
    }
}
