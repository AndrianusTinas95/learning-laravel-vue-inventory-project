<?php

namespace App\Http\Controllers;

use App\Model\Product;
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
        $products = Product::with([
            'brand'=>function($q){
                $q->select('id','name');
            },
            'category'=>function($q){
                $q->select('id','name');
            },
            'description'=>function($q){
                $q->select('id','name');
            },
            'location'=>function($q){
                $q->select('id','name');
            },
            'manufacture'=>function($q){
                $q->select('id','name');
            }
        ])->orderBy('created_at','desc')->get();
        return response()->json(['products'=> $products],200);
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
        foreach ($request->input('products') as $key => $value) {
            Product::updateOrCreate([
                'serial' => $request->input('products.'.$key.'.serial')
            ],[
                'serial' => $request->input('products.'.$key.'.serial'),
                'quantity' => $request->input('products.'.$key.'.quantity'),
                'manufacture_id' => $request->input('products.'.$key.'.manufacture'),
                'description_id' => $request->input('products.'.$key.'.description'),
                'location_id' => $request->input('products.'.$key.'.location'),
                'category_id' => $request->input('products.'.$key.'.category'),
                'brand_id' => $request->input('products.'.$key.'.model'),
                'status' => $request->input('products.'.$key.'.status'),
            ]);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'serial created'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
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
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
