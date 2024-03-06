<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->take(3)->get();

        return self::responseSuccess("Datos obtenidos exitosamente", ProductResource::collection($products) );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {


        try {

            $productData = $request->validated();


            DB::beginTransaction();

            $product = new Product();
            $product->fill($productData);
            $product->save();

            DB::commit();
            return self::responseSuccess("Se creo producto exitosamente",  $productData);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al crear producto", $th);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($productId)
    {
        try {

            $product = Product::find($productId);

           if (!isset($product)) {
                return self::responseError("No existe producto");
           }

            return self::responseSuccess("Se obtuvo el prododucto existosamente", new ProductResource($product));

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al encontrar producto", $th);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $productId)
    {
        try {

            $productData = $request->validated();

            DB::beginTransaction();

            $product = Product::findOrFail($productId);
            $product->fill($productData);
            $product->update();

            DB::commit();
            return self::responseSuccess("Se actualizo el producto exitosamente");

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al actualizar producto", $th);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        try {

            $product = Product::find($productId);

           if (!isset($product)) {
                return self::responseError("No existe producto");
           }

           DB::beginTransaction();

           $product->delete();

           DB::commit();

            return self::responseSuccess("Se elimino el producto existosamente");

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al eliminar producto", $th);

        }
    }
}
