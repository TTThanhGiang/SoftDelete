<?php
namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ProductService {
    protected $model;
    public function __construct(Product $poduct)
    {
        $this->model = $poduct;
    }

    public function getlist()
    {
        return Product::all();
    }

    public function create($params){
        try{
            
            $params['status']=1;
            return $this->model->create($params);
        }catch(Exception $exception){
            Log::error($exception);
            return false;
        }
    }
    public function update($product, $params) {
        try{
            
            $params['status']=0;
            return $product->update($params);
        }catch(Exception $exception){
            Log::error($exception);
            return false;
        }
    }
    public function delete($id){
        $product = Product::findOrFail($id);
        return $product->delete();
    }

    public function restore($id){
        $product = Product::withTrashed()->findOrFail($id);
        if($product->trashed()){
            $product->restore();
            return $product;
        }
        throw new ModelNotFoundException('Product is not deleted');
    }
}