<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::paginate(25);
        return $this->successResponse([
            'Products' => ProductResource::collection($product->load('images')),
            'links' => ProductResource::collection($product)->response()->getData()->links,
            'meta' => ProductResource::collection($product)->response()->getData()->meta
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'primary_image' => 'required|image',
            'description' => 'required',
            'price' => 'integer',
            'quantity' => 'integer',
            'delivery_amount' => 'integer',
            'images.*' => 'image'
        ]);
        if ($validator->failed()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $primary_image_name = Carbon::now()->microsecond . '.' . $request->primary_image->extension();
        $request->primary_image->storeAs('images/products', $primary_image_name, 'public');
        if ($request->has('images')) {
            $product_file_name_images = [];
            foreach ($request->images as $image) {
                $file_image_name = Carbon::now()->microsecond . '.' . $image->extension();
                $image->storeAs('images/products', $file_image_name, 'public');
                array_push($product_file_name_images, $file_image_name);
            }
        }
        $product = Product::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'primary_image' => $primary_image_name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'delivery_amount' => $request->delivery_amount

        ]);
        if ($request->has('images')) {
            foreach ($product_file_name_images as $image_name) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image_name
                ]);
            }
        }
        return $this->successResponse(new ProductResource($product->load('images')), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->successResponse(new ProductResource($product->load('images')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'primary_image' => 'image|nullable',
            'description' => 'required',
            'price' => 'integer',
            'quantity' => 'integer',
            'delivery_amount' => 'integer',
            'images.*' => 'image|nullable'
        ]);
        if ($validator->failed()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        if ($request->has('primary_image')) {
            $primary_image_name = Carbon::now()->microsecond . '.' . $request->primary_image->extension();
            $request->primary_image->storeAs('images/products', $primary_image_name, 'public');
        }
        if ($request->has('images')) {
            $product_file_name_images = [];
            foreach ($request->images as $image) {
                $file_image_name = Carbon::now()->microsecond . '.' . $image->extension();
                $image->storeAs('images/products', $file_image_name, 'public');
                array_push($product_file_name_images, $file_image_name);
            }
        }

        $product->update([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'primary_image' => $request->has('primary_image') ? $primary_image_name : $product->primary_image,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'delivery_amount' => $request->delivery_amount

        ]);
        if ($request->has('images')) {
            foreach ($product->images as $product_image) {
                $product_image->delete();
            }
            foreach ($product_file_name_images as $image_name) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image_name
                ]);
            }
        }
        return $this->successResponse(new ProductResource($product->load('images')), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->successResponse(new ProductResource($product), 200);
    }
}
