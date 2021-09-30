<?php
namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Session;
require app_path().'/start/constants.php';

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'idcliente', 'nombre', 'apellido', 'dni', 'telefono', 'direccion', 'codigo_postal', 'fecha_nac', 'correo', 'fk_idusuario'
    ];

    protected $hidden = [   

    ];

    public function cargarDesdeRequest($request)
    {
        $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->dni = $request->input('txtDni');
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->codigo_postal = $request->input('txtCodigo_postal');
        $this->fecha_nac = $request->input('txtFechaNac');
        $this->correo = $request->input('txtCorreo');
        $this->fk_idusuario = $request->input('lstUsuario');
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.nombre',
            1 => 'A.apellido',
            2 => 'A.dni',
            3 => 'A.telefono',
            4 => 'A.direccion',
            5 => 'A.codigo_postal',
            6 => 'A.fecha_nac',
            7 => 'A.correo',
            8 => 'A.fk_idusuario'
        );
        $sql = "SELECT DISTINCT
                    A.idcliente,
                    A.nombre,
                    A.apellido,
                    A.dni,
                    A.telefono,
                    A.direccion,
                    A.codigo_postal,
                    A.fecha_nac,
                    A.correo,
                    A.fk_idusuario,
                    B.usuario
                    FROM clientes A
                    INNER JOIN sistema_usuarios B ON  A.fk_idusuario = B.idusuario
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.nombre LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.apellido LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.dni LIKE '%" . $request['search']['value'] . "%')";
            $sql .= " OR A.telefono LIKE '%" . $request['search']['value'] . "%')";
            $sql .= " OR A.direccion LIKE '%" . $request['search']['value'] . "%')";
            $sql .= " OR A.codigo_postal LIKE '%" . $request['search']['value'] . "%')";
            $sql .= " OR A.fecha_nac LIKE '%" . $request['search']['value'] . "%')";
            $sql .= " OR A.correo LIKE '%" . $request['search']['value'] . "%')";
            $sql .= " OR B.usuario LIKE '%" . $request['search']['value'] . "%')";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM clientes ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idcliente)
    {
        $sql = "SELECT * FROM clientes WHERE idcliente = $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->dni = $lstRetorno[0]->dni;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->codigo_postal = $lstRetorno[0]->codigo_postal;
            $this->fecha_nac = $lstRetorno[0]->fecha_nac;
            $this->correo = $lstRetorno[0]->correo;
            $this->fk_idusuario = $lstRetorno[0]->fk_idusuario;
            return $this;
        }
        return null;
    }

   public function obtenerClientePorUsuario($idusuario){
        $sql ="SELECT 
            A.idcliente,
            A.nombre,
            A.apellido,
            A.dni,
            A.telefono,
            A.direccion,
            A.codigo_postal,
            A.fecha_nac,
            A.correo,
            A.fk_idusuario
            FROM clientes A
            WHERE A.fk_idusuario = '$idusuario'";
        $lstRetorno = DB::select($sql);
       
        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->dni = $lstRetorno[0]->dni;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->codigo_postal = $lstRetorno[0]->codigo_postal;
            $this->fecha_nac = $lstRetorno[0]->fecha_nac;
            $this->correo = $lstRetorno[0]->correo;
            $this->fk_idusuario = $lstRetorno[0]->fk_idusuario;
            return $this;
        }
        return null;
   }

    public function guardar()
    {
        $sql = "UPDATE clientes SET
            idcliente = '$this->idcliente',
            nombre = '$this->nombre',
            apellido = '$this->apellido',
            dni = '$this->dni',
            telefono = '$this->telefono',
            direccion = '$this->direccion',
            codigo_postal = '$this->codigo_postal',
            fecha_nac = '$this->fecha_nac',
            correo = '$this->correo',
            fk_idusuario = '$this->fk_idusuario'
            WHERE idcliente=?";
        
        $affected = DB::update($sql, [$this->idcliente]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM clientes WHERE
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO clientes (
                nombre,
                apellido,
                dni,
                telefono,
                direccion,
                codigo_postal,
                fecha_nac,
                correo,
                fk_idusuario
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->dni,
            $this->telefono,
            $this->direccion,
            $this->codigo_postal,
            $this->fecha_nac,
            $this->correo,
            $this->fk_idusuario
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }
    
    

}