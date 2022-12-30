<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Minhaz;
use Exception;
use Illuminate\Http\Request;
use Storage;

class MinhazController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query  = Minhaz::latest();
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
if ( !empty( $request->file( "image" ) ) ) {$data["image"] = $this->upload( $request->image, "minhaz" );}                $res = Minhaz::create($data); 
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Minhaz  $minhaz
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Minhaz $minhaz)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $minhaz;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Minhaz  $minhaz
     * @return \Illuminate\Http\Response
     */
    public function edit(Minhaz $minhaz)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Minhaz  $minhaz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Minhaz $minhaz)
    {
        if ($this->validateCheck($request, $minhaz->id)) {
            try {
                $data = $request->all();
                // push the update text
if ( !empty( $request->file( "image" ) ) ) {$oldFile = $this->oldFile($minhaz->image );Storage::delete( $oldFile );$data["image"] = $this->upload( $request->image, "minhaz" );}                $minhaz->fill( $data )->save();

                return $this->responseReturn( "update", $minhaz );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Minhaz  $minhaz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Minhaz $minhaz)
    {
        $res = $minhaz->delete();
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
