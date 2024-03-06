<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
 
        return self::responseSuccess("Datos obtenidos exitosamente", CategoryResource::collection($categories) ); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try {

            $categoryData = $request->validated();

            
            DB::beginTransaction();

            $category = new Category();
            $category->fill($categoryData);
            $category->save();

            DB::commit();
            return self::responseSuccess("Se creo categoria exitosamente",  $category);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al crear categoria", $th);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        try {

            $category = Category::find($categoryId);

           if (!isset($product)) {
                return self::responseError("No existe producto");
           }

            return self::responseSuccess("Se obtuvo el prododucto existosamente", new CategoryResource($category));

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al encontrar producto", $th);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $categoryId)
    {
        try {

            $categoryData = $request->validated();

            DB::beginTransaction();

            $category = Category::findOrFail($categoryId);
            $category->fill($categoryData);
            $category->update();

            DB::commit();
            return self::responseSuccess("Se actualizo el category exitosamente");

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al actualizar category", $th);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoryId)
    {
        try {

            $category = Category::find($categoryId);

           if (!isset($category)) {
                return self::responseError("No existe categoria");
           }
        
           DB::beginTransaction();

           $category->delete();

           DB::commit();

            return self::responseSuccess("Se elimino el categoria existosamente");

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al eliminar categoria", $th);

        }
    }
}
