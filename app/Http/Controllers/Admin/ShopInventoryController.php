<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin;

use Storage;
use Exception;
use Illuminate\Http\Request;
use App\Models\ShopInventory;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\BaseController;

class ShopInventoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query  = ShopInventory::with('product')
            ->join('view_shop_item_stock', 'view_shop_item_stock.product_id', '=', 'shop_inventories.product_id')
            ->select('*', DB::raw('view_shop_item_stock.inventory_in - view_shop_item_stock.sale_qty as quantity'))
            ->latest();
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
                $res = ShopInventory::create($data); 
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopInventory  $shopInventory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ShopInventory $shopInventory)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $shopInventory;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopInventory  $shopInventory
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopInventory $shopInventory)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopInventory  $shopInventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopInventory $shopInventory)
    {
        if ($this->validateCheck($request, $shopInventory->id)) {
            try {
                $data = $request->all();
                // push the update text
                $shopInventory->fill( $data )->save();

                return $this->responseReturn( "update", $shopInventory );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopInventory  $shopInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopInventory $shopInventory)
    {
        $res = $shopInventory->delete();
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
