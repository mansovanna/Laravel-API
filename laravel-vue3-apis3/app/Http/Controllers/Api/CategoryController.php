<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function index()
    {

        $cetegories = Category::get();

        if ($cetegories->count() > 0) {
            return CategoryResource::collection($cetegories);
        }
        return response()->json([
            'message' => 'No record available!'
        ], 200);
    }

    public function store(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mendetory',
                'error' => $validator->messages(),
            ], 422);
        }


        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(
            [
                'message' => 'Categories Created Successfuly!',
                'data' => new CategoryResource($category)
            ],
            200
        );
    }


    public function show(Category $category)
    {

        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {

        $validator =  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mendetory',
                'error' => $validator->messages(),
            ], 422);
        }


        $category -> update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(
            [
                'message' => 'Categories Update Successfuly!',
                'data' => new CategoryResource($category)
            ],
            200
        );
    }

    public function destroy(Category $category) {
        $category -> delete();

        return response()->json(
            [
                'message' => 'Product Deleted Successful',
                'data' => new CategoryResource($category)
            ],
            200
        );
    }
}
