<?php

/**
 *  Clase que controla los usuarios
 */
class Usuarios extends Controller
{

	function __construct($parametros = [])
	{

		parent::__construct(array('usuarios'));
		$this->verificarAcceso();
		$this->usuario = $this->model('Usuario');
		$this->login = $this->model('Login');
		$this->perfil = $this->model('Perfil');
	}

	function index()
	{
		$this->listados();
	}

	/**
	 * Listado de todos los usuarios
	 */
	function listados($parametros = [])
	{
		$this->verificarPermiso('L');
		//$this->verificarModulo('Usuarios');
		$datos = [
			'usuarios' => $this->usuario->getAllUsuariosPerfiles()
		];
		$this->header();
		$this->view('paginas/usuarios/listado', $datos);
		$this->footer();
	}

	/**
	 * view para ver o modificar un usuario
	 */
	function nuevo($parametros = [])
	{
		$this->verificarPermiso('L');
		//$this->verificarModulo('Usuarios');
		$parametros[0] = isset($parametros[0]) ? $parametros[0] : 0;
		$datos = [
			'usuario' => $this->usuario->searchUsuario($parametros[0]),
			'perfiles' => $this->perfil->getAllPerfiles()
		];
		$this->header();
		$this->view('paginas/usuarios/nuevo', $datos);
		$this->footer();
	}

	function clave()
	{
		$this->verificarPermiso('M');
		$datos = [
			'usuario' => $this->login->obtenerUsuario(),
			'perfiles' => $this->perfil->getAllPerfiles()
		];
		$this->header();
		$this->view('paginas/usuarios/cambiar_clave', $datos);
		$this->footer();
	}


	/**
	 * Cambia la clave del usuario Logueado
	 */
	function cambiarClave()
	{
		$this->verificarPermiso('M');
		if (isset($_POST) && isset($_POST['clave_actual']) && isset($_POST['clave'])) {
			$retorno = array();
			$usuario = $this->login->obtenerUsuario();
			if (password_verify($_POST['clave_actual'], $usuario['clave'])) {
				if ($this->usuario->cambiarClave($usuario['id'], $_POST['clave'])) {
					$retorno['msj'] = "Clave modificada correctamente";
				} else {
					$retorno['msj'] = "ERROR AL MODIFICAR LA CLAVE";
				}
			} else {
				$retorno['msj'] = "Clave actual ingresada es incorrecta";
			}
			echo "<script> alert('" . $retorno['msj'] . "');</script>";
		}
		$this->redir('Usuarios');
	}

	function misDatos()
	{
		$this->verificarPermiso('L');
		$datos = [
			'usuario' => $this->login->obtenerUsuario(),
			'perfiles' => $this->perfil->getAllPerfiles()
		];
		$this->header();
		$this->view('paginas/usuarios/mis_datos', $datos);
		$this->footer();
	}

	/**
	 * Actualiza los datos del usuario logueado
	 */
	function actualizarMisDatos($parametros = [])
	{
		$this->verificarPermiso('M');
		if (isset($_POST)) {
			$retorno = array();
			$usuario = $this->login->obtenerUsuario();
			if (count($usuario) > 0) {
				$us_save = array();
				$us_save['id'] = $usuario['id'];
				$us_save['nombre'] = $_POST['nombre'];
				$us_save['apellido'] = $_POST['apellido'];
				$us_save['email'] = $_POST['correo'];
				$us_save['telefono'] = $_POST['telefono'];
				if ($this->usuario->save($us_save, $us_save['id'])) {
					$retorno['msj'] = "Datos Personales modificados correctamente";
				} else {
					$retorno['msj'] = "No se pudo modificar los datos";
				}
				echo "<script> alert('" . $retorno['msj'] . "');</script>";
			}
		}
		$this->redir('Usuarios');
	}

	function save()
	{
		$this->verificarPermiso('A');
		$retorno = [];
		$retorno['cod'] = 0;
		$retorno['msj'] = 'Iniciando';
		if (isset($_POST['id']) && isset($_POST['usuario'])) {
			$u = null;
			//$this->usuario = $this->model('Usuario');
			$resultado = array();
			$usuario = array();
			$u = null;

			if ($_POST['id'] != '') {
				$u = $this->usuario->searchUsuario($_POST['id']);
				$usuario['id'] = $_POST['id'];
			}
			if (!empty($_POST['clave'])) {
				$usuario['clave'] = $_POST['clave'];
			}
			$usuario['nombre'] = $_POST['nombre'];
			$usuario['apellido'] = $_POST['apellido'];
			$usuario['id_perfil'] = $_POST['id_perfil'];
			$usuario['usuario'] = $_POST['usuario'];
			$usuario['email'] = $_POST['email'];
			$usuario['telefono'] = $_POST['telefono'];
			$usuario['dni'] = $_POST['documento'];
			$usuario['id_municipio'] = $_POST['id_municipio'];

			$resultado = false;
			if ($u != null) {
				$resultado = $this->usuario->save($usuario);
				$retorno['msj'] = "Registro Modificado correctamente.";
			} else {
				if ($this->usuario->userExists($_POST['usuario'])) {
					$retorno['msj'] = "El nombre de usuario se encuentra registrado.";
				} else {
					unset($usuario['id']);
					$resultado = $this->usuario->save($usuario);
					$retorno['msj'] = "Registro agregado correctamente.";
				}
			}

			if (!$resultado) {
				$retorno['msj'] = "Error al save el registro." . $this->usuario->getError();
			}

			$this->alerta($retorno['msj']);
		}
		$this->redir('Usuarios');
	}

	public function eliminar($parametros = [])
	{
		if ($this->usuario->baja($parametros[0])) {
			$retorno['cod'] = 1;
			$retorno['msj'] = "Usuario dado de BAJA correctamente.";
		} else {
			$retorno['cod'] = -1;
			$retorno['msj'] = "Error en la operacion.";
		}
		$this->alerta($retorno['msj']);
		$this->redir('Usuarios');
	}

	public function alta($parametros = [])
	{
		if ($this->usuario->alta($parametros[0])) {
			$retorno['cod'] = 1;
			$retorno['msj'] = "Usuario dado de ALTA correctamente.";
		} else {
			$retorno['cod'] = -1;
			$retorno['msj'] = "Error en la operacion.";
		}
		$this->alerta($retorno['msj']);
		$this->redir('Usuarios');
	}

	public function search()
	{
		if (isset($_POST)) {
			$usuario = ($_POST['campo'] == 'documento') ? $this->usuario->searchPorDni($_POST['dato']) : $this->usuario->searchPorNombreDeUsuario($_POST['dato']);
		} else {
			$usuario = null;
		}
		echo json_encode($usuario);
	}
}
