<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $carrera=Carrera::all();
            return DataTables::of($carrera)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn="<div class='d-flex align-items-center justify-content-center gap-4'>";
                    $btn.="<button class='btn btn-danger' onclick='eliminarCarrera($row->id)'>Eliminar</button>";
                    $btn.="<button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editarModal' onclick='editarCarrera($row->id, \"$row->carreras\")'>Editar</button> </div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $facultades=Facultad::all();
        return view('Carreras.index',compact('facultades'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrera $carrera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrera $carrera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrera $carrera)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrera $carrera)
    {
        //
    }
}
