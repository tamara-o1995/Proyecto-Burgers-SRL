<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;


class ControladorWebRegistrate extends Controller
{
   
    
    public function index()
    {
        $mje = " ";
        return view('web.registrate', compact('mje'));

    }
    public function registrar(Request $request)
    {
        $user = new Usuario();
        $usuario = $request->input('txtUsuario');
        $nombre = $request->input('txtNombre');
        $apellido =  $request->input('txtApellido');
        $mail =  $request->input('txtCorreo');
        $clave =  $request->input('txtClave');
        $clave2 = $request->input('txtClave2');
        
        if(!empty($nombre) && !empty($apellido) &&!empty($usuario) &&!empty($mail)){

            if(!empty($clave) && !empty($clave2) && $clave == $clave2){
                if(count($user->validarUsuario($usuario)) == 0){
  
                    $pass = password_hash($clave, PASSWORD_DEFAULT);
                    $user->usuario = $usuario;
                    $user->nombre = $nombre;
                    $user->apellido = $apellido;
                    $user->mail = $mail;
                    $user->clave = $pass;

                    $user->insertar();
                    return view('web.login');
                }else{
                    $mje = "Usuario existente";
                    return view('web.registrate', compact('mje'));
                }
            }else{
                $mje = "Las claves no coinciden";
                return view('web.registrate', compact('mje'));
            }
        }else{
            $mje = "Complete todos los campos";
            return view('web.registrate', compact('mje'));
        }
    }   
}

?>