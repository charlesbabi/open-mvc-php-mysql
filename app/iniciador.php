<?php

//Cargamos las librerias
require_once 'config/configurar.php';

//Autoload php
spl_autoload_register(function ($class_name) {
	if (file_exists(RUTA_APP.'/core/' . $class_name . '.php')) {
		require_once RUTA_APP.'/core/' . $class_name . '.php';
	} else if (file_exists(RUTA_APP.'/controllers/' . $class_name . '.php')) {
		require_once RUTA_APP.'/controllers/' . $class_name . '.php';
	} else {
		echo "Class not found " . $class_name;
		exit();
	}
});
