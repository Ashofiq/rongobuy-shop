<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\MinhazTest;
use Exception;
use Illuminate\Http\Request;
use Storage;

class MinhazTestController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query  = MinhazTest::latest();
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
                $res = MinhazTest::create($data); 
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MinhazTest  $minhazTest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MinhazTest $minhazTest)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $minhazTest;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MinhazTest  $minhazTest
     * @return \Illuminate\Http\Response
     */
    public function edit(MinhazTest $minhazTest)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MinhazTest  $minhazTest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MinhazTest $minhazTest)
    {
        if ($this->validateCheck($request, $minhazTest->id)) {
            try {
                $data = $request->all();
                // push the update text
                $minhazTest->fill( $data )->save();

                return $this->responseReturn( "update", $minhazTest );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MinhazTest  $minhazTest
     * @return \Illuminate\Http\Response
     */
    public function destroy(MinhazTest $minhazTest)
    {
        $res = $minhazTest->delete();
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
