<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Imagen_producto extends Model
{
    protected $table = 'imagen_productos';
    public $timestamps = false;

    protected $fillable = [
        'idimagen', 'nombre', 
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request)
    {
        $this->idimagen = $request->input('id') != "0" ? $request->input('id') : $this->idimagen;
        $this->nombre = $request->input('txtNombre');
       
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idimagen,
                  A.nombre
                FROM imagen_productos A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idimagen)
    {
        $sql = "SELECT
                idimagen,
                nombre
              
                FROM imagen_productos WHERE idarchivo = $idimagen";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idimagen = $lstRetorno[0]->idimagen;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE imagen_productos SET
            nombre='$this->nombre'
            WHERE idimagen=?";
        $affected = DB::update($sql, [$this->idimagen]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM imagen_productos WHERE
            idimagen=?";
        $affected = DB::delete($sql, [$this->idimagen]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO imagen_productos (
                nombre
                
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idimagen = DB::getPdo()->lastInsertId();
    }

}