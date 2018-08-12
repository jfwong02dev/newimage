<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::withTrashed()->get();

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'productName' => 'required|unique:products,name|min:3',
        ]);

        $product = Product::create([
            'name' => $request->productName,
        ]);

        $product->code = 'PD' . $product->id;
        $product->save();

        session()->flash('added_product', 'You successfully added a new product. Name: ' . $request->productName);

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'editProductName' => 'required|min:3|unique:products,name,' . $product->id,
        ]);

        $product->name = $request->editProductName;
        $product->save();

        session()->flash('updated_product', 'You successfully updated a product, ID: ' . $product->id . '.');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('deleted_product', 'You successfully deleted a product, Name: ' . $product->name . '.');

        return redirect(route('products.index'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->restore();

        session()->flash('restored_product', 'You successfully restored a product, Name: ' . $product->name . '.');

        return redirect(route('products.index'));
    }
}
