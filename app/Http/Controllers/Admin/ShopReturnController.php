<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin;

use Storage;
use Exception;
use App\Models\Product;
use App\Models\ShopSale;
use App\Models\ShopReturn;
use Illuminate\Http\Request;
use App\Models\ShopReturnItem;
use App\Http\Resources\Resource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\BaseController;

class ShopReturnController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query  = ShopReturn::join('shop_sales', 'shop_sales.id', '=', 'shop_returns.shop_sale_id');
        $query->whereLike( $request->field_name, $request->value );

        $datas  = $query
                        // ->select('order_no', 'customer_mobile', DB::select(''))
                        ->paginate($request->pagination);
        return new Resource($datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend_app');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                $data = $request->all();
                // push the insert text
                // $res = ShopReturn::create($data); 
                $res = $this->createReturn($request);
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function createReturn($request)
    {   
        $sale = ShopSale::where('order_no', $request->orderNo)->first();

        $shopReturn = new ShopReturn();
        $shopReturn->shop_sale_id = $sale->id;
        $shopReturn->date = date('Y-m-d');
        $shopReturn->save();

        foreach ($request->products as $key => $item) {
            $product = Product::find($item['id']);
            $newItem = new ShopReturnItem();
            $newItem->productId = $product->id;
            $newItem->quantity = $item['quantity'];
            $newItem->shop_return_id = $shopReturn->id;
            $newItem->price = $product->shop_price;
            $newItem->total = $product->shop_price * $item['quantity'];
            $newItem->save();
        }

        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopReturn  $shopReturn
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ShopReturn $shopReturn)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $shopReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopReturn  $shopReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopReturn $shopReturn)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopReturn  $shopReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopReturn $shopReturn)
    {
        if ($this->validateCheck($request, $shopReturn->id)) {
            try {
                $data = $request->all();
                // push the update text
                $shopReturn->fill( $data )->save();

                return $this->responseReturn( "update", $shopReturn );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopReturn  $shopReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopReturn $shopReturn)
    {
        $res = $shopReturn->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id=null)
    {
        return true;
        return $request->validate([
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ],[
            //ex: 'name' => "This name is required" (custom message)
        ]);
    }
}
