--ANDRÉS DELGADO HERRUZO

--SCRIPT PARA CREAR LA BASE DE DATOS PARA ADMINISTRAR LOS INICIOS DE SESION DE LOS MINIJUEGOS

CREATE DATABASE minijuegos2;

USE minijuegos2;

CREATE TABLE usuarios(
    idUsuario TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    correo VARCHAR(100) NOT NULL UNIQUE,
    pw VARCHAR(255) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    perfil VARCHAR(20)
);