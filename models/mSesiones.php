<?php    
    class mSesiones{
        private $conexion;
        private $variables;

        public function __construct(){
            require_once __DIR__ . '/../config/configdb.php';
            require_once __DIR__ . '/../variables/variables.php';
            $this->variables = new Variables();
            $this->conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BBDD);
            if ($this->conexion->connect_error) {
                die("Error de conexión: " . $this->conexion->connect_error);
            }
        
            if (!$this->conexion->set_charset("utf8")) {
                printf("Error al establecer la conexión a UTF-8: %s\n", $this->conexion->error);
                exit();
            }
        }
        public function mCrearAdminM($nombre_admin_minijuego, $password, $correo_admin_minijuego, $perfil_admin_minijuego) {
            // COGEMOS LOS VALORES DE LAS VARIABLES DEL ARCHIVO VARIABLES.PHP
            $tabla = $this->variables->tabla; 
            $correo = $this->variables->correo;
            $pw = $this->variables->pw;
            $nombre = $this->variables->nombre;
            $perfil = $this->variables->perfil;
        
            //CREAR HASH DE LA CONTRASEÑA
            $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
        
            // CONSULTA SQL PARA LA CONSULTA PREPARADA
            $sql_insertar_admin_minijuego = "INSERT INTO $tabla ($correo, $pw, $nombre, $perfil) VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql_insertar_admin_minijuego);
            $stmt->bind_param("ssss", $correo_admin_minijuego, $password_hasheada, $nombre_admin_minijuego, $perfil_admin_minijuego);
            $stmt->execute();
            $stmt->close();
        }

        public function  mCrearAdminGeneral($nombre_admin, $password, $correo_admin, $perfil_admin){
            // COGEMOS LOS VALORES DE LAS VARIABLES DEL ARCHIVO VARIABLES.PHP
            $tabla = $this->variables->tabla; 
            $correo = $this->variables->correo;
            $pw = $this->variables->pw;
            $nombre = $this->variables->nombre;
            $perfil = $this->variables->perfil;
        
            //CREAR HASH DE LA CONTRASEÑA
            $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
        
            // CONSULTA SQL PARA LA CONSULTA PREPARADA
            $sql_insertar_admin_minijuego = "INSERT INTO $tabla ($correo, $pw, $nombre, $perfil) VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql_insertar_admin_minijuego);
            $stmt->bind_param("ssss", $correo_admin, $password_hasheada, $nombre_admin, $perfil_admin);
            $stmt->execute();

            $filas_afectadas = $stmt->affected_rows;
            $stmt->close();
            if ($filas_afectadas > 0) {
                return 0;
            } else {
                return 1;
            }

        }        
        
        public function mIniciarSesion($correo_admin_minijuego, $password) {
            $tabla = $this->variables->tabla;
            $correo = $this->variables->correo;
            $pw = $this->variables->pw;
            $nombre = $this->variables->nombre;
            $perfil = $this->variables->perfil;
        
            $sql_comprobar_usuario = "SELECT * FROM $tabla WHERE $correo = ?";
            $stmt = $this->conexion->prepare($sql_comprobar_usuario);
            $stmt->bind_param("s", $correo_admin_minijuego);
            $stmt->execute();
            $resultado = $stmt->get_result();
        
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
        
                //VERIFICA LA CONTRASEÑA ENCRIPTADA
                if (password_verify($password, $fila['pw'])) {
                    $_SESSION = [];
                    $_SESSION['nombre'] = $fila['nombre'];
                    $_SESSION['pw'] = $fila['pw'];
                    $_SESSION['correo'] = $fila['correo'];
                    $_SESSION['perfil'] = $fila['perfil'];
                } else {
                    echo 'Contraseña Incorrecta';
                }
            } else {
                echo 'No existe el usuario';
            }
        
            $stmt->close();
            return $_SESSION;
        }
        public function mComprobarAdmin(){
            $tabla = $this->variables->tabla;
            $perfil = $this->variables->perfil;
            $sql = "SELECT * FROM $tabla WHERE $perfil = ?";
            $tipoPerfil = 'a';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $tipoPerfil);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $stmt->close();
            if($resultado->num_rows > 0)
                return 1;
            else return ;
        }   
        
        public function mCerrarSesion(){
            session_destroy();
            //dejo el array de sesion vacio
            $_SESSION = array();
        }
    }