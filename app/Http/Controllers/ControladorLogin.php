<?php

namespace App\Http\Controllers;

// use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Area;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Menu;
use Illuminate\Support\Facades\Auth;
use Session;

require app_path() . '/start/constants.php';

class ControladorLogin extends Controller
{
    public function index(Request $request)
    {
        $titulo = 'Acceso';

        // if((substr($request->ip(), 0, 7 ) == "157.92.") || $request->ip() == "190.2.6.187") {
        return view('sistema.login', compact('titulo'));
        //   } else {
        //       return redirect(env('APP_URL_AUTOGESTION') . '');
        //   }
    }

    public function login(Request $request)
    {
        return view('sistema.home');
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect('admin/login');
    }

    public function entrar(Request $request)
    {
        $usuarioIngresado = $request->input('txtUsuario');
        $claveIngresada = $request->input('txtClave');

        $usuario = new Usuario();
        $lstUsuario = $usuario->validarUsuario($usuarioIngresado);

        if (count($lstUsuario) > 0){
            if ($usuario->validarClave($claveIngresada, $lstUsuario[0]->clave)){
                $titulo = 'Inicio';
                $request->session()->put('usuario_id', $lstUsuario[0]->idusuario);
                $request->session()->put('usuario', $lstUsuario[0]->usuario);
                $request->session()->put('usuario_nombre', $lstUsuario[0]->nombre . " " . $lstUsuario[0]->apellido);

                $usuario->idusuario = $lstUsuario[0]->idusuario;
                $usuario->actualizarFechaIngreso();

                //Carga los grupos de cuentas de usuario
                $grupo = new Area();
                $aGrupo = $grupo->obtenerAreasDelUsuario($lstUsuario[0]->idusuario);
                $request->session()->put('array_grupos', $aGrupo);

                //Grupo predeterminado
                if (isset($lstUsuario[0]->areapredeterminada) && $lstUsuario[0]->areapredeterminada != "")
                    $request->session()->put('grupo_id', $lstUsuario[0]->areapredeterminada);
                else
                    $request->session()->put('grupo_id', $aGrupo[0]->idarea);

                //Carga los permisos del usuario
                $familia = new Patente();
                $aPermisos = $familia->obtenerPatentesDelUsuario();
                if (count($aPermisos) > 0) {
                    $request->session()->put('array_permisos', $aPermisos);
                }

                //Carga el menu
                $menu = new Menu();
                $aMenu = $menu->obtenerMenuDelGrupo(Session::get('grupo_id'));
                if (count($aMenu) > 0) {
                    $request->session()->put('array_menu', $aMenu);
                }
                return view('sistema.index', compact('titulo'));
            }
            else {
                    $titulo = 'Acceso denegado';
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Credenciales incorrectas";
                    return view('sistema.login', compact('titulo', 'msg'));
                }
        }else {
            $titulo = 'Acceso denegado';
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Credenciales incorrectas";
            return view('sistema.login', compact('titulo', 'msg'));
            
            
    } 
    }
}
