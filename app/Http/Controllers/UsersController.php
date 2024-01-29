<?php

namespace App\Http\Controllers;

use App\Events\InteractionEvent;
use App\Models\Gif;
use Illuminate\Http\Request;
use App\Services\GiphyService;
use App\Http\Resources\Gif as GifResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use Illuminate\Support\Facades\Validator;
class UsersController extends Controller
{
    protected $giphyService;

    public function __construct(GiphyService $giphyService)
    {
        $this->giphyService = $giphyService;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
            'limit' => 'numeric',
            'offset' => 'numeric',

        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $params = [
            'q' => $request->input('query'),
            'limit' => $request->input('limit'),
            'offset' => $request->input('offset'),
        ];
        return  $this->giphyService->search(array_filter($params));
    }

    public function show(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
    
            ]);
            if ($validator->fails()){
                return response(['errors'=>$validator->errors()->all()], 422);
            }

            $gif = Gif::findOrFail($request->input('id'));
            $gif->giphy_info= $this->giphyService->getId($gif->gif_id);
           
            return new GifResource($gif);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Gif not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gif_id' => 'required|string',
            'alias' => 'required|string',
            'user_id' => 'required|numeric',

        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $gif = new Gif();
        $gif->setGif($request->all());
    }

    public static function routes()
    {
        Route::apiResource('gifs', UsersController::class)->except(['destroy', 'update'])->names('api.gifs');
    }
}
