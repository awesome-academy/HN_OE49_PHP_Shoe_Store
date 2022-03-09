<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderby('created_at', 'DESC')->get();

        return view('admins.products.index')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();

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
        if ($request->hasFile('images')) {
            $product = Product::create([
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
            Image::insert($data);
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
        $product = Product::findorfail($id);
        $images = Image::where('product_id', $product->id)->get();

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
        $brands = Brand::all();
        $product = Product::findorfail($id);
        $images = Image::where('product_id', $product->id)->get();

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
        $product = Product::findorfail($id);
        $upload_path = public_path('images/products/');
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'brand_id' => $request->brand_id,
            'desc' => $request->desc,
        ]);
        if ($request->hasFile('images')) {
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
                Image::insert($data);
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
        $product = Product::findorfail($id);
        $upload_path = public_path('images/products/');
        $images = Image::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            if (File::exists($upload_path . $image->name)) {
                File::delete($upload_path . $image->name);
            }
        }
        $product->delete();

        return redirect()->route('products.index')->with('message', __('delete success'));
    }

    public function deleteImage($id)
    {
        $images = Image::findOrFail($id);
        $upload_path = 'images/products/';
        if (File::exists($upload_path . $images->name)) {
            File::delete($upload_path . $images->name);
        }
        $images->delete();

        return back();
    }
}
