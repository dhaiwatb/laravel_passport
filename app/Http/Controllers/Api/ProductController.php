<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        if(count($products) > 0){

            return $this->sendSuccessResponse(compact('products'), 200);
        }
        else{
            $data['message'] = "Products not found";

            return $this->sendErrorResponse($data, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);
        // dd($validator->errors()->toArray());
        
        if ($validator->fails()) {
            // return response()->json($validator->errors(), 422);
            return $this->sendErrorResponse($validator->errors()->toArray(), 422);
        }
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return $this->sendSuccessResponse(compact('product'), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;

        $product->save();

        return $this->sendSuccessResponse(compact('product'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if($product){

            $product->delete();
    
            $data['message'] = "Product Deleted";
    
            return $this->sendSuccessResponse($data, 200);
        }
        else{
            return $this->sendErrorResponse(['message' => 'Product not found'], 200);
        }

    }
}
