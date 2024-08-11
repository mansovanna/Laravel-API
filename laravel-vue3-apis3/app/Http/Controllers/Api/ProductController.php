<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        $prodects = Product::get();

        if ($prodects->count() > 0) {
            return ProductResource::collection($prodects);
        } else {
            return response()->json(
                [
                    'message' => 'No record available'
                ],
                200
            );
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mendetory',
                'error' => $validator->messages(),
            ], 422);
        }


        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json(
            [
                'message' => 'Product Created Successful',
                'data' => new ProductResource($product)
            ],
            200
        );
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mendetory',
                'error' => $validator->messages(),
            ], 422);
        }


        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json(
            [
                'message' => 'Product Update Successful',
                'data' => new ProductResource($product)
            ],
            200
        );
    }


    public function destroy(Product $product)
    {
        $product->delete();


        return response()->json(
            [
                'message' => 'Product Deleted Successful',
                'data' => new ProductResource($product)
            ],
            200
        );
    }
}
