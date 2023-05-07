<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(25);
        return $this->successResponse([
            'brands' => CategoryResource::collection($categories),
            'links' => CategoryResource::collection($categories)->response()->getData()->links,
            'meta' => CategoryResource::collection($categories)->response()->getData()->meta
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'parent_id' => 'required|integer'
        ]);
        if ($validator->failed()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description
        ]);
        return $this->successResponse(new CategoryResource($category), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->successResponse(new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'parent_id' => 'required|integer'
        ]);
        if ($validator->failed()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description
        ]);
        return $this->successResponse(new CategoryResource($category), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->successResponse(new CategoryResource($category), 200);
    }

    public function children(Category $category)
    {
        return $this->successResponse(new CategoryResource($category->load('children')), 200);
    }
}
