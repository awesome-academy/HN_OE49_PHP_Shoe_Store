<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Product;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        return view('admins.products.index')->with(compact('products', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = $this->brandRepo->getAll();

        return view('admins.products.create')->with(compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = [];
        $files = $request->file('images');
        if ($request->has('images')) {
            $product = $this->productRepo->create([
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'brand_id' => $request->brand_id,
                'desc' => $request->desc,
            ]);
            foreach ($files as $key => $file) {
                $new_name = time() .'-' . $file->getClientOriginalName();
                $file->move(public_path('images/products/'), $new_name);
                $data[$key] = [
                    'product_id' => $product->id,
                    'name' => $new_name,
                ];
            }
            $this->imageRepo->insert($data);
        }

        return redirect()->route('products.create')->with('message', __('create success'));
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

        return view('admins.products.show')->with(compact('product', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = $this->brandRepo->getAll();
        $product = $this->productRepo->find($id);
        $images = $this->imageRepo->getImage($product->id);

        return view('admins.products.edit')->with(compact('brands', 'product', 'images'));
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
        $product = $this->productRepo->find($id);
        $upload_path = public_path('images/products/');
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'brand_id' => $request->brand_id,
            'desc' => $request->desc,
        ]);
        if ($request->has('images')) {
            $data = [];
            if ($files = $request->file('images')) {
                foreach ($files as $key => $file) {
                    $new_name = time() . '-' . $file->getClientOriginalName();
                    $file->move($upload_path, $new_name);
                    $data[$key] = [
                        'product_id' => $product->id,
                        'name' => $new_name,
                    ];
                }
                $this->imageRepo->insert($data);
            }
        }
        return redirect()->route('products.index')->with('message', __('update success'));
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

        return redirect()->route('products.index')->with('message', __('delete success'));
    }

    public function deleteImage($id)
    {
        $images = $this->imageRepo->find($id);
        $file_name = 'images/products/' . $images->name;
        $this->imageRepo->deleteFileImage($file_name);
        $images->delete();

        return back();
    }
}
