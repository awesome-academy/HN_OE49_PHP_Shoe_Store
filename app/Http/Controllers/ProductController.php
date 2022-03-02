<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Http\Requests\Products\StoreRequest;
use Illuminate\Http\Request;

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

        return redirect()->route('products.create')->with('success', 'create success');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
