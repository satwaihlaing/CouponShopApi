<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);
        
        $shops = Shop::get();
        return response()->json([
            'success' => 1,
            'code' => 200,
            'meta' => [
                "method" => "GET",
                "endpoint" => $request->path(),
                "limit"=> default_limit($request->limit),
                "offset"=> default_offset($request->offset),
                "total"=> count($shops)
            ],
            'data' => $shops,
            'errors' => [],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'nullable|string',
            'query' => 'nullable|string' ,
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'zoom' => 'nullable|string'
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'query' => $request->query,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'success' => 1,
            'code' => 201,
            'meta' => [
                "method" => "POST",
                "endpoint" => $request->path(),
            ],
            'data' => ["id"=> $shop->id],
            'errors' => [],
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $validator = $request->validate([
            'id' => 'required|integer',
        ]);

        $shop = Shop::find($id);
        if($shop){
            return response()->json([
                'success' => 1,
                'code' => 200,
                'meta' => [
                    "method" => "GET",
                    "endpoint" => $request->path(),
                ],
                'data' => $shop,
                'errors' => [],
            ], 200); 
        }

        return response()->json([
            'success' => 0,
            'code' => 404,
            'meta' => [
                "method" => "GET",
                "endpoint" => $request->path(),
            ],
            'errors' => [
                "message" => "The resource that matches the request ID does not found.",
                'code' => 404002,
            ],
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'id' => 'required|integer',
            'name' => 'nullable|string',
            'query' => 'nullable|string' ,
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'zoom' => 'nullable|string'
        ]);

        $shop = Shop::find($id);
        $shop->update([
            'name' => $request->name,
            'query' => $request->query,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $validator = $request->validate([
            'id' => 'required|integer',
        ]);
        $shop = Shop::find($id);

        if(!$shop){
            return response()->json([
                'success' => 0,
                'code' => 404,
                'meta' => [
                    "method" => "DELETE",
                    "endpoint" => $request->path(),
                ],
                'errors' => [
                    "message" => "The deleting resource that corresponds to the ID wasn't found.",
                    'code' => 404002,
                ],
            ], 200);
        }
        $shop->delete();
        return response()->json([
            'success' => 1,
            'code' => 200,
            'meta' => [
                "method" => "DELETE",
                "endpoint" => $request->path(),
            ],
            'data' => ["deleted"=> 1],
            'errors' => [],
        ], 200);
    }
}
