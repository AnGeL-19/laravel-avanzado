<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::with('rateable')->get();

        return self::responseSuccess("Datos obtenidos exitosamente",  $ratings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRatingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRatingRequest $request, $model, $modelId)
    {
        // GURDAR EL RATING DE LOS PRODUCTOS O USUARIOS
        try {

            $modelData = $request->validated();

            $modelRating = [];

            switch ($model) {
                case 'product':

                    $product = Product::find($modelId);
                    $modelRating = [
                        'id' => isset($product) ? $product->id : null,
                        'model' => Product::class
                    ];
                    break;

                case 'category':
                    $category = Category::find($modelId);
                    $modelRating = [
                        'id' => isset($category) ? $category->id : null,
                        'model' => Category::class
                    ];
                    break;

                case 'user':
                    $user = User::find($modelId);
                    $modelRating = [
                        'id' => isset($user) ? $user->id : null,
                        'model' => User::class
                    ];

                    break;
                default:
                    return self::responseError("El modelo no es valido");
                    break;
            }

            if (!isset($modelRating['id'])) {
                return self::responseError("El ". $model ." no existe");
            }

            DB::beginTransaction();

            
            $rating = new Rating();
            $rating->rateable_type = $modelRating['model'];
            $rating->rateable_id = $modelRating['id'];
            $rating->fill($modelData);

            $rating->save();
           

            DB::commit();
            return self::responseSuccess("Se creo la evaluacion exitosamente", $rating);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al evaluar", $th);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRatingRequest  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
