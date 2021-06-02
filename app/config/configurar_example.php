<?php

/**
 * En este archivo se crearan todas las constantes del sistema.
 * todas las constantes deben estar definidas EN MAYUSCULAS
 * Aca se debe defin como constantes a utilizar las carpetas de archivos adjuntos, expedientes, otras referencias estaticas
 * RECORDAR: No debe existir referencia a una carpeta que no sea una CONSTANTE predefinida.
 */

//Configuracion de acceso a la BD
define('DB_HOST', 'localhost');
define('DB_PUERTO', '3306');
define('DB_USUARIO', '{DATABASE_USER}');
define('DB_PASSWORD', '{DATABASE_PASSWORD}');
define('DB_NOMBRE', '{DATABASE_NAME}');

//Ruta de la aplicación
define('RUTA_APP', dirname(dirname(__FILE__)));
define('RUTA_PUBLIC', dirname(dirname(dirname(__FILE__))) . '/public');

$protocol = 'https://';
if (!isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS'])) {
    $protocol = 'http://';
}

$servidor = $_SERVER["SERVER_NAME"] . ':' . $_SERVER['SERVER_PORT'];

/**
 * Se utiliza para las referencias a las llamadas de todos los archivos
 */
define('RUTA_URL', $protocol . $servidor . '/{PROJECT_FOLDER_NAME}');
//Definir las carpetas a utilizar de las librerias a incorporar
define('URL_LIB', RUTA_URL . '/lib');
define('URL_JS', RUTA_URL . '/js');
define('URL_CSS', RUTA_URL . '/css');
define('URL_IMG', RUTA_URL . '/img');
define('URL_COMPONENTES', RUTA_URL . '/vendor/components');

//Definir dominio para las cookies
define('DOMINIO', 'mvcphpmysql.sistema.com');

//Pagina de inicio de la Web o del sistema.
define('PAGINA_INICIO', $protocol . $servidor . '/');

// Variable para el title de la pagina general
define('NOMBRESITIO', 'Sistema de Gestión');

//Variable para manejar en que version del softwawre se encuentra
define('AUTOR', 'Open MVC');
define('VERSIONDELSOFTWARE', '0.7.0');

//nombre del sistema para el manejo de sesiones, debe ser nombre unico por sistema, para que no compartan sesiones
define('NOMBRESISTEMA', '{SESSION_NAME}');
define('SECURE', false);

//Cantidad de segundos que puede estar inactivo
define('MAX_IDLE_TIME', 144000);

//Hash que define como se comprueban y se guardan las claves
define('HASH_CLAVE', PASSWORD_DEFAULT);

//CONFIGURACION PARA ENVIAR CORREOS
define('MAILER_HOST', '{MAILER_HOST}');
define('MAILER_PUERTO', '{MAILER_PORT}');
define('MAILER_USUARIO', '{MAILER_USER}');
define('MAILER_CLAVE', '{MAILER_PASSWORD}');

//Datos a utilizar para pruebas o debug
define('DEBUG', true);
define('ENVIAR_CORREOS', true);

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('displays_error', '1');
}
