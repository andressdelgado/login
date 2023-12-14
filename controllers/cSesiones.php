<?php    
    require_once __DIR__ . '/../models/mSesiones.php';
    class  cSesiones{
        public $nombrePagina;
        public $view;
        public $mensaje;
        public $objSesiones;
        public function __construct(){
            $this->view = '';
            $this->nombrePagina = '';
            $this->objSesiones = new mSesiones();
        }
        public function registro_Administradores_Minijuegos(){
            $this->view = 'vRegistro';
            $this->nombrePagina = 'Página de Registro';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST["nombre_usuario"]) && isset($_POST["password"]) && isset($_POST["correo_usuario"])){
                    $nombre_admin_minijuego = $_POST["nombre_usuario"];
                    $password = $_POST["password"];
                    $correo_admin_minijuego = $_POST["correo_usuario"];
                    $perfil_admin_minijuego = "m";
                    $this->objSesiones->mCrearAdminM($nombre_admin_minijuego, $password, $correo_admin_minijuego, $perfil_admin_minijuego);
                }
            }
        }
        public function registro_Administrador(){
            $this->view = 'vRegistro';
            $this->nombrePagina = 'Página de Registro';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST["nombre_usuario"]) && isset($_POST["password"]) && isset($_POST["correo_usuario"])){
                    $nombre_admin = $_POST["nombre_usuario"];
                    $password = $_POST["password"];
                    $correo_admin = $_POST["correo_usuario"];
                    $perfil_admin = "a";
                    $resultado = $this->objSesiones->mCrearAdminGeneral($nombre_admin, $password, $correo_admin, $perfil_admin);
                    if($resultado==0)
                        header("Location: index.php?c=cSesiones&m=inicio_Sesion");
                }
            }
        }
        public function inicio_Sesion(){
            $this->view = 'vInicioSesion';
            $this->nombrePagina = 'Página de Inicio de Sesion';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST["correo_usuario"]) && isset($_POST["password"])){
                    $correo_admin_minijuego = $_POST["correo_usuario"];
                    $password = $_POST["password"];
                    $sesion = $this->objSesiones->mIniciarSesion($correo_admin_minijuego, $password);
                    switch ($sesion['perfil']) {
                        case 'a':
                            header("Location: index.php?c=cSesiones&m=paginaAdmin");
                            break; 
                        case 'm':
                            header("Location: index.php?c=cSesiones&m=paginaAdminJuego");
                            break; 
                        default:
                            break;
                    }
                }
            }
        }
        public function cerrar_Sesion(){
            $this->view = '';
            $this->nombrePagina = '';
            $this->objSesiones->mCerrarSesion();
            header("Location: index.php?c=cInicio&m=mostrarPaginaPrincipal");
        }
        public function paginaAdmin(){
            $this->view = 'vAdmin';
            $this->nombrePagina = 'Página del Admin';
        }
        public function paginaAdminJuego(){
            $this->view = 'vAdminJuego';
            $this->nombrePagina = 'Página del Admin del Juego';
            
        }

    }