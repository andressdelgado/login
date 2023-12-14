<?php    
    require_once __DIR__ . '/../models/mSesiones.php';
    class  cInicio{
        public $nombrePagina;
        public $view;
        public $mensaje;
        public function __construct(){
            $this->view = '';
            $this->nombrePagina = '';
            $this->objSesiones = new mSesiones();
        }
        public function mostrarPaginaAdmin(){
            $this->view = 'vRegistroAdmin';
            $this->nombrePagina = 'Página Principal';
        }
        public function mostrarPaginaPrincipal(){
            $this->view = 'vInicioSesion';
            $this->nombrePagina = 'Iniciar Sesión';
        }
        public function comprobarPaginaInicio(){
            $resultado = $this->objSesiones->mComprobarAdmin();
            if($resultado == 0)
                header("Location: index.php?m=cInicio&m=mostrarPaginaAdmin");
            else
                header("Location: index.php?m=cInicio&m=mostrarPaginaPrincipal");
        }
    }