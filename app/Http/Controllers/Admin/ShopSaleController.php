<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin;

use Storage;
use Exception;
use App\Models\ShopSale;
use App\Models\ShopProduct;
use App\Models\ShopSaleItem;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\BaseController;

class ShopSaleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query  = ShopSale::latest();
        $query->whereLike( $request->field_name, $request->value );

        $datas  = $query->paginate($request->pagination);
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
                // $res = ShopSale::create($data); 
                $sale = $this->createSale($request);
                $this->createSaleItem($request, $sale->id);
                return $this->responseReturn( "create", $sale );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function createSale($request)
    {
        $sale = new ShopSale();
        $sale->orderNo = self::orderNoGen();
        $sale->date = date('Y-m-d');
        $sale->customer_mobile = $request->customer_mobile;
        $sale->save();
        return $sale;
    }

    public function orderNoGen()
    {
        $order = ShopSale::latest()->first();
        $lastOrderId = $order != null ? $order->id : 1;
        $lastOrderId = $lastOrderId == 1 ? $lastOrderId : $lastOrderId + 1;
        return ShopSale::ORDERNO_PREFIX .'-'.date('Y-m-d').'-'.$lastOrderId;
    }

    public function createSaleItem($request, $saleId)
    {
        foreach ($request->products as $key => $value) {
            $product = ShopProduct::find($value['id']);

            if ($product != null) {
                $item = new ShopSaleItem();
                $item->shop_sale_id = $saleId;
                $item->productId = $product->id;
                $item->quantity = $value['quantity'];
                $item->price = $product->shop_price;
                $item->total = $product->shop_price * $value['quantity'];
                $item->save();
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopSale  $shopSale
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ShopSale $shopSale)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $shopSale;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopSale  $shopSale
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopSale $shopSale)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopSale  $shopSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopSale $shopSale)
    {
        if ($this->validateCheck($request, $shopSale->id)) {
            try {
                $data = $request->all();
                // push the update text
                $shopSale->fill( $data )->save();

                return $this->responseReturn( "update", $shopSale );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopSale  $shopSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopSale $shopSale)
    {
        $res = $shopSale->delete();
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
