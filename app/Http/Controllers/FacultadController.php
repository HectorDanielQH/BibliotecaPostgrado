<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FacultadController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $facultades=Facultad::all();
            return DataTables::of($facultades)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn="<div class='d-flex align-items-center justify-content-center gap-4'>";
                    $btn.="<button class='btn btn-danger' onclick='eliminarFacultad($row->id)'>Eliminar</button>";
                    $btn.="<button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editarModal' onclick='editarFacultad($row->id, \"$row->nombre\")'>Editar</button> </div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Facultades.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Facultad::create([
            'nombre' => $request->facultad,
        ]);
        return response()->json(['success'=>'La Facultad fue agregada correctamente.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facultad $facultad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facultad $facultad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $facultad)
    {
        $facultad=Facultad::find($facultad);
        $facultad->nombre=$request->facultad;
        $facultad->save();
        return response()->json(['success'=>'La Facultad fue actualizada correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($facultad)
    {
        $facultad=Facultad::find($facultad);
        $facultad->delete();
        return response()->json(['success'=>'La Facultad fue eliminada correctamente.']);
    }
}
