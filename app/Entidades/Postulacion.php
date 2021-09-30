<?php
namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Session;
require app_path().'/start/constants.php';

class Postulacion extends Model
{
    protected $table = 'postulaciones';
    public $timestamps = false;

    protected $fillable = [
        'idpostulante', 'nombre', 'apellido', 'correo', 'whatsapp', 'adjunto_cv'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idpostulante = $request->input('id') != "0" ? $request->input('id') : $this->idpostulante;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->correo = $request->input('txtCorreo');
        $this->whatsapp = $request->input('txtWhatsapp');

    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpostulante',
            1 => 'A.nombre',
            2 => 'A.apellido',
            3 => 'A.correo',
            4 => 'A.whatsapp',
            5 => 'A.adjunto_cv',
            
        );
        $sql = "SELECT DISTINCT
        A.idpostulante,
        A.nombre,
        A.apellido,
        A.correo,
        A.whatsapp,
        A.adjunto_cv
        FROM   postulaciones A
    WHERE 1=1
                ";
                //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.idpostulante LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.nombre LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.apellido LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.correo LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.whatsapp LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.adjunto_cv LIKE '%" . $request['search']['value'] . "%')";
        }

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    public function obtenerTodos()
    {
        $sql = "SELECT * FROM postulacion ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPostulante)
    {
        $sql = "SELECT
                idpostulante,
                nombre,
                apellido,
                correo,
                whatsapp,
                adjunto_cv,
                msj
        FROM postulaciones WHERE idpostulante = $idPostulante";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpostulante = $lstRetorno[0]->idpostulante;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->whatsapp = $lstRetorno[0]->whatsapp;
            $this->adjunto_cv = $lstRetorno[0]->adjunto_cv;
            $this->msj = $lstRetorno[0]->msj;
            return $this;
        }
        return null;
    }


    public function guardar()
    {
        $sql = "UPDATE postulaciones SET
            idpostulante = '$this->idpostulante',
            nombre = '$this->nombre',
            apellido = '$this->apellido',
            correo = '$this->correo',
            whatsapp = '$this->whatsapp',
            adjunto_cv = '$this->adjunto_cv'

            WHERE idpostulante=?";
        
        $affected = DB::update($sql, [$this->idpostulante]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM postulaciones WHERE
            idpostulante=?";
        $affected = DB::delete($sql, [$this->idpostulante]);
    }
         
    public function insertar()
    {
        $sql = "INSERT INTO postulaciones (
                nombre,
                apellido,
                correo,
                whatsapp,
                adjunto_cv,
                msj
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->correo,
            $this->whatsapp,
            $this->adjunto_cv,
            $this->msj
        ]);
        return $this->idpostulante = DB::getPdo()->lastInsertId();
    }
}
