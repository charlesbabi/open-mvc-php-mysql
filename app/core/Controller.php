<?php
class Controller
{
	/**
	 * Funcion constructora de todos los controllers
	 */
	function __construct($parametros = array())
	{
	}

	/**
	 * Instancia un objeto del model tal cual como se llama el archivo y la clase
	 */
	static function model($model)
	{
		require_once '../app/models/' . $model . '.php';
		return new $model();
	}

	/**
	 * Carga (require_once) una view de la carpeta app/views tal cual como se llama el archivo
	 */
	public function view($view, $datos = [])
	{
		if (file_exists('../app/views/' . $view . '.php')) {
			require_once '../app/views/' . $view . '.php';
		} else {
			echo 'La view no Existe.';
		}
	}

	/**
	 * Carga (require_once) archivos helpers de la carpeta app/helpers para incorporar archivos php extras
	 */
	public function helper($helper)
	{
		$file = '../app/helpers/' . $helper . '.php';
		if (file_exists($file)) {
			require_once $file;
		} else {
			echo 'El Helper no Existe.';
		}
	}

	/**
	 * Carga (require_once) el Header incluido en app/views/inc/
	 */
	public function header()
	{
		if (file_exists('../app/views/inc/header.php')) {
			$datos = $this->model('Login')->obtenerUsuario();
			require_once '../app/views/inc/header.php';
			$this->helper('constantes_js');
			$this->menu($datos['id_perfil']);
		} else {
			echo 'La view no Existe.';
		}
	}

	/**
	 * Carga (require_once) el Menu incluido en app/views/inc/
	 */
	public function menu($id_perfil = '')
	{
		if (file_exists('../app/views/inc/menu.php')) {
			$datos = $this->model('Menu')->obtenerMenu($id_perfil);
			require_once '../app/views/inc/menu.php';
		} else {
			echo 'La view no Existe.';
		}
	}

	/**
	 * Carga (require_once) el Footer incluido en app/views/inc/
	 */
	public function footer()
	{
		if (file_exists('../app/views/inc/footer.php')) {
			require_once '../app/views/inc/footer.php';
		} else {
			echo 'La view no Existe.';
		}
	}

	/**
	 * Redirecciona a un controlador, y una accion
	 * $controlador = controlador donde quiero dirigir
	 * $accion = Funcion del controlador que llamare
	 */
	public function redir($controlador = 'Home', $accion = 'index')
	{
		echo '<script> window.location.href = "' . RUTA_URL . '/' . $controlador . '/' . $accion . '" </script>';
		exit();
	}

	/**
	 * Verifica si esta logueado el usuario en caso contrario envia al controlador acceso
	 */
	function verificarAcceso()
	{
		$login = $this->model('Login');
		//Con esto verificamos que se encuentre logueado
		if (!$login->verificarLogin()) {
			$this->redir('Acceso');
		}
	}

	function alerta($alerta)
	{
		echo "<script> alert('$alerta'); </script>";
	}

	/**
	 * Funcion para subir un archivo a la carpeta indicada
	 * $archivo : 			se debe para el $_FILES['nombre_de_campo']
	 * $nombre_archivo :	Nombre que tendra el archivo
	 * $carpeta: 			Carpeta donde se alojará el archivo
	 * $opciones: 			Arreglo con opciones para habilitar o deshabilitar
	 */

	function subirArchivo($archivo, $nombre_archivo = '', $carpeta = 'tmp', $opciones = [])
	{
		//configuracion de variable de retorno
		$retorno = array();
		$retorno['codigo'] = 0;
		$retorno['mensaje'] = '';
		$retorno['archivo'] = array();

		//se verifican si existen opciones o se habiltiar los valores estandares
		if (!isset($opciones['publica'])) {
			$opciones['publica'] = true;
		}
		if ($opciones['publica']) {
			$base = RUTA_PUBLIC;
		} else {
			$base = RUTA_APP;
		}
		if (!isset($opciones['max_size'])) {
			$opciones['max_size'] = 100000000;
		}
		if (!isset($opciones['excluir'])) {
			$opciones['excluir'] = array();
		} else {
			$opciones['excluir'] = explode(",", $opciones['excluir']);
		}

		$tipos_de_archivos = array(
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'csv' => 'text/csv',
			'pdf' => 'application/pdf',
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'zip' => 'application',
			'odt' => 'application/vnd.oasis.opendocument.text',
			'doc' => 'application/msword',
			'svg' => 'image/svg+xml',
			'rtf' => 'application/rtf',
		);

		$archivos_permitidos = array();
		if (count($opciones['excluir']) > 0) {
			foreach ($tipos_de_archivos as $key => $value) {
				if (!array_search($key, $opciones['excluir'])) {
					$archivos_permitidos[$key] = $value;
				}
			}
		} else {
			$archivos_permitidos = $tipos_de_archivos;
		}

		try {
			//se controla que no tenga error el archivo temporal
			if (!isset($archivo['error']) || is_array($archivo['error'])) {
				throw new RuntimeException('Parametro inválido.');
			}
			switch ($archivo['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No se envio el archivo.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Tamaño de archivo excedido.');
				default:
					throw new RuntimeException('Error desconocido.');
			}

			//Controla el tamaño maximo del archivo
			if ($archivo['size'] > $opciones['max_size']) {
				throw new RuntimeException('Tamaño de archivo excedido.');
			}

			//controla el tipo de archivo subido
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			if (false === $ext = array_search(
				$finfo->file($archivo['tmp_name']),
				$archivos_permitidos,
				true
			)) {
				throw new RuntimeException('Formato de archivo invalido.');
			}

			//directorio donde alojar la carpeta
			$directorio = $base . '/' . $carpeta;
			if (!move_uploaded_file(
				$archivo['tmp_name'],
				sprintf(
					$directorio . '/%s.%s',
					$nombre_archivo,
					$ext
				)
			)) {
				throw new RuntimeException('Error al mover el archivo a la carpeta: ' . $directorio);
			}
			$retorno['archivo']['nombre'] = $nombre_archivo;
			$retorno['archivo']['directorio'] = $directorio;
			$retorno['archivo']['extension'] = $ext;
		} catch (Exception $e) {
			$retorno['codigo'] = -1;
			$retorno['mensaje'] = $e->getMessage();
		}
		return $retorno;
	}

	/** 
	 * Función para evaluar si un usuario autenticado puede o no realizar una acción
	 * $perfil: Es el id_perfil que tiene que tener el usuario para permitir realizar la acción
	 */
	function permitirAccion($array)
	{
		if (array_search($_SESSION['id_perfil'], $array) === false) {
			echo "<script>alert('No tenés permisos para realizar esta acción')</script>";
			$this->redir('Home');
		} else {
			return true;
		}
	}

	function verificarModulo($modulo = '')
	{
		$this->perfil = $this->model('Perfil');
		$this->sesion = $this->model('Sesion');
		$acceder = false;
		$i = 0;
		$permisos = $this->perfil->getAllPermisos($this->sesion->obtenerValor('id_perfil'));
		while ($acceder == false && $i < count($permisos)) {
			if ($permisos[$i]['url'] == $modulo) {
				$acceder = true;
			}
			$i++;
		}
		if (!$acceder) {
			$this->redir();
		}
	}

	/**
	 * Retorna si el usuario loguado es administrador
	 */
	public function esAdmin()
	{
		$parametros = $this->model('Parametro');
		$sesion = $this->model('Sesion');
		$retorno = false;
		if ($sesion->obtenerValor('id_perfil') == $parametros->getById('id_pefil_admin')) {
			$retorno = true;
		}
		return $retorno;
	}

	public function verificarPermiso($permiso = 'X')
	{

		$retorno = false;
		if (!$this->esAdmin()) {
			$retorno = true;
		} else {
			$sesion = $this->model('Sesion');
			$lista_permisos = (array) $sesion->obtenerValor('permisos');
			foreach ($lista_permisos as $per) {
				if (strtolower($per['controlador']) == strtolower(get_class($this))) {
					if (stripos($per['permisos'], $permiso) !== false) {
						$retorno = true;
					}
				}
			}
		}
		if($retorno===false){
			$this->alerta("Permiso denegado.");
			$this->redir('Home');
		}
	}
}
