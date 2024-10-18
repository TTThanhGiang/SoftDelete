<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\CreateRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Http\Requests\Api\Product\DeleteRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(CreateRequest $createRequest): JsonResponse|ProductResource{
        
        $request = $createRequest->validated();
        $result = $this->productService->create($request);

        if($result){
            return new ProductResource($result);
        }

        return response()->json([
            'msg'=> 'Them moi loi'
        ]);
    }
    public function show(Product $product){
        return new ProductResource($product);
    }

    public function showlist(){
        $products = $this->productService->getlist();
        return ProductResource::collection($products);
    }
    public function update(Product $product, UpdateRequest $updateRequest){
        $request = $updateRequest->validated();
        $result = $this->productService->update($product, $request);
        if($result){
            return response()->json([
                'msg'=> 'Cap nhat thanh cong'
            ]);
        }

        return response()->json([
            'msg'=> 'Cap nhat loi'
        ]);
    }
    public function delete(Product $product, DeleteRequest $deleteRequest){
        $request = $deleteRequest->validated();
        $result = $this->productService->delete($product->id);
        if($result){
            return response()->json([
                'msg'=> 'Xoa thanh cong'
            ]);
        }

        return response()->json([
            'msg'=> 'Xoa nhat loi'
        ]);
    }

    public function restore($id){
        try{
            $product = $this->productService->restore($id);
            return response()->json([
                'message' => 'Phuc hoi thanh cong',
                'product' => $product,
            ], 200);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'msg' => $e->getMessage()
            ],404);
        }catch(\Exception $e){
            return response()->json([
                 'An error occurred'
            ],500);
        }
    }
}
