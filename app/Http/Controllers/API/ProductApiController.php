<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Product;


class ProductApiController extends Controller
{
    //
    public function all(Request $request) 
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if($id)
        {
            $product = Product::with(['category', 'galleries'])->find($id);

            if($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data product berhasil diambil'
                );
            }
            else {
                return ResponseFormatter::error(
                    null,
                    'Data product tidak ada',
                    404
                );
            }
        }
        $product = Product::with(['category', 'galleries']);

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if($description) {
            $product->where('description', 'like', '%' . $description . '%');
        }
        if($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }
        if($price_from) {
            $product->where('price_from', 'like' ,'%' . $price_from . '%');
        }
        if($price_to) {
            $product->where('price_to', 'like' ,'%' . $price_to . '%');
        }
        if($categories) {
            $product->where('tags', 'like', '%' . $categories . '%');
        }

        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data Product berhasil diambil'
        );
    }
}
