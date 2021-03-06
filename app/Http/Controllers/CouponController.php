<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use App\Shop;
use Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::get();
        return response()->json([
            'success' => 1,
            'code' => 200,
            'meta' => [
                "method" => "GET",
                "endpoint" => $request->path(),
                "limit" => default_limit($request->limit),
                "offset" => default_offset($request->offset),
                "total" => count($coupon)
            ],
            'data' => $coupon,
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fix-amount',
            'amount' => 'required|integer',
            'image_url' => 'nullable|string',
            'code' => 'nullable|integer',
            'start_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'end_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'coupon_type' => 'required|in:public,private',
            'used_count' => 'nullable|image',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::create([
            "name" => $request->name,
            "description" => $request->description,
            "discount_type" => $request->discount_type,
            "amount" => $request->amount,
            "image_url" => $request->image_url,
            "code" => $request->code,
            "start_datetime" => $request->start_datetime,
            "end_datetime" => $request->end_datetime,
            "coupon_type" => $request->coupon_type,
            "used_count" => $request->used_count,
        ]);

        return response()->json([
            'success' => 1,
            'code' => 201,
            'meta' => [
                "method" => "POST",
                "endpoint" => $request->path(),
            ],
            'data' => ["id" => $coupon->id],
            'errors' => [],
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::find($id);
        if ($coupon) {
            return response()->json([
                'success' => 1,
                'code' => 200,
                'meta' => [
                    "method" => "GET",
                    "endpoint" => $request->path(),
                ],
                'data' => $coupon,
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fix-amount',
            'amount' => 'required|integer',
            'image_url' => 'nullable|string',
            'code' => 'nullable|integer',
            'start_datetime' => 'nullable',
            'end_datetime' => 'nullable',
            'coupon_type' => 'required|in:public,private',
            'used_count' => 'nullable|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'success' => 0,
                'code' => 404,
                'meta' => [
                    "method" => "PUT",
                    "endpoint" => $request->path(),
                ],
                'errors' => [
                    "message" => "The updating resource that corresponds to the ID wasn't found.",
                    'code' => 404002,
                ],
            ], 200);
        }

        $coupon->update([
            "name" => $request->name,
            "description" => $request->description,
            "discount_type" => $request->discount_type,
            "amount" => $request->amount,
            "image_url" => $request->image_url,
            "code" => $request->code,
            "start_datetime" => $request->start_datetime,
            "end_datetime" => $request->end_datetime,
            "coupon_type" => $request->coupon_type,
            "used_count" => $request->used_count,
        ]);

        return response()->json([
            'success' => 1,
            'code' => 201,
            'meta' => [
                "method" => "PUT",
                "endpoint" => $request->path(),
            ],
            'data' => ["updated" => 1],
            'errors' => [],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::find($id);
        if (!$coupon) {
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
        $coupon->delete();
        return response()->json([
            'success' => 1,
            'code' => 200,
            'meta' => [
                "method" => "DELETE",
                "endpoint" => $request->path(),
            ],
            'data' => ["deleted" => 1],
            'errors' => [],
        ], 200);
    }


    // =========================Coupon Shop======================================//

    public function couponShop(Request $request, $id)
    {

        $validation = Validator::make($request->all(), [
            'coupon_id' => 'required|integer',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::with('shops')->find($request->coupon_id);

        return response()->json([
            'success' => 1,
            'code' => 200,
            'meta' => [
                "method" => "GET",
                "endpoint" => $request->path(),
                "limit" => default_limit($request->limit),
                "offset" => default_offset($request->offset),
                "total" => count($coupon)
            ],
            'data' => $coupon,
            'errors' => [],
        ], 200);
    }

    public function couponShopFilter(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'coupon_id' => 'required|integer',
            'shop_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $shop_id = $request->shop_id;
        $couponshop = Coupon::with(['shops' => function ($query) use ($shop_id) {
            $query->where('id', $shop_id);
        }])->find($request->coupon_id);

        return response()->json([
            'success' => 1,
            'code' => 200,
            'meta' => [
                "method" => "GET",
                "endpoint" => $request->path(),
            ],
            'data' => $couponshop,
            'errors' => [],
        ], 200);
    }

    public function CreateCuponShop(Request $request){

        $validation = Validator::make($request->all(), [
            'coupon_id' => 'required|integer',
            'shop_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }
        
        $shop_id = $request->shop_id;
        $coupon = Coupon::find($request->coupon_id);

        if(!$coupon){
            return response()->json([
                'success' => 0,
                'code' => 200,
                'meta' => [
                    "method" => "POST",
                    "endpoint" => $request->path(),
                ],
                'errors' => [
                    "message" => "The parent resource of corresponding to the given ID was not found.",
                    "code" => 404005
                ],
            ], 200);
        }

        $couponshop = Coupon::with(['shops' => function ($query) use ($shop_id) {
            $query->where('id', $shop_id);
        }])->find($request->coupon_id);

        
        
        if(count($couponshop->shops)){
            $coupon->shops()->attach($shop_id);

            return response()->json([
                'success' => 1,
                'code' => 200,
                'meta' => [
                    "method" => "POST",
                    "endpoint" => $request->path(),
                ],
                'data' => [
                    "id" => $shop_id,
                ],
                'error' => [],
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'code' => 200,
            'meta' => [
                "method" => "POST",
                "endpoint" => $request->path(),
            ],
            'errors' => [
                "message" => "The inserting resource was already registered.",
                "code" => 409001
            ],
        ], 200);
    }

    public function deleteCouponShop(Request $request){
        
        $validation = Validator::make($request->all(), [
            'coupon_id' => 'required|integer',
            'id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->getMessageBag()->first(),
            ], 200);
        }

        $coupon = Coupon::find($request->coupon_id);
        $coupon->shops()->detach($request->id);

        $shop = Shop::find($request->id);
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
